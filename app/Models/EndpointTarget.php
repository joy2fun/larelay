<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Model;
use Log;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Throwable;

class EndpointTarget extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'endpoint_targets';

    const enabled = [
        1 => "Yes",
        0 => "No",
    ];

    const methods = [
        'GET' => 'GET',
        'POST' => 'POST',
        'PUT' => 'PUT',
        'HEAD' => 'HEAD',
        'DELETE' => 'DELETE',
    ];

    public function endpoint()
    {
        return $this->belongsTo(Endpoint::class, 'endpoint_id', 'id');
    }

    public function buildHeaders()
    {
        $headers = json_decode($this->headers ?? '', true);
        if (! $headers) {
            // pass through all headers except the "host"
            return collect(request()->headers->all())->except("host")->toArray();
        }
        $placeholders = self::parsePlaceHolders($headers);
        $trans = $this->evaluatePlaceholdersAsTrans($placeholders);
        $this->evaluateArrayValues($headers, $trans);
        return $headers;
    }

    public function buildBody()
    {
        $body = json_decode($this->body ?? '', true);
        if (! $body) {
            return request()->all();
        }
        $placeholders = self::parsePlaceHolders($body);
        $trans = $this->evaluatePlaceholdersAsTrans($placeholders);
        $this->evaluateArrayValues($body, $trans);
        return $body;
    }

    public static function parsePlaceHolders($input)
    {
        if (is_scalar($input)) {
            $array = json_decode($input ?? '', true);
            if (! $array) {
                return [];
            }
        } elseif (is_array($input)) {
            $array = $input;
        } else {
            return [];
        }
        $all = [];

        foreach($array as & $item) {
            if (is_array($item)) {
                return array_merge($all, self::parsePlaceHolders($item));
            } else {
                preg_match_all("~{{(?<expr>.*?)}}~ix", $item, $matches);
                if ($matches['expr'] ?? null) {
                    $expressions = array_unique($matches['expr']);
                    foreach($expressions as $expr) {
                        if (strlen(trim($expr))) {
                            $all[] = $expr;
                        }
                    }
                }
            }
        }

        return array_unique($all);
    }

    public function evaluateArrayValues(& $array, $trans)
    {
        foreach($array as & $item) {
            if (is_array($item)) {
                $this->evaluateArrayValues($item, $trans);
            } else {
                if (preg_match_all("~{{(?<expr>.*?)}}~ix", $item)) {
                    $item = strtr($item, $trans);
                }
            }
        }
    }

    public function evaluatePlaceholdersAsTrans($placeholders)
    {
        $trans = [];
        foreach($placeholders as $expr) {
            $trans[sprintf("{{%s}}", $expr)] = $this->evaluate($expr);
        }
        return $trans;
    }

    public function evaluate($expr)
    {
        try {
            return (new ExpressionLanguage)->evaluate($expr, [
                'req' => request(),
                'now' => now(),
            ]);
        } catch (Throwable $e) {
            report($e);
        }
    }

    public function passedRule()
    {
        if (is_null($this->rule) || ! strlen($this->rule)) {
            return true;
        }

        $result = $this->evaluate($this->rule);
        Log::warning(sprintf('rule [%s] evaluated', $this->rule), [$result]);
        
        return $result;
    }

}
