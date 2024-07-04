<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class EndpointTarget extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'endpoint_targets';
    

    const enabled = [
        1 => "是",
        0 => "否",
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

    protected function headersArray(): Attribute
    {
        return Attribute::make(
            get: fn () => json_decode($this->headers, true),
        );
    }

    protected function bodyArray(): Attribute
    {
        return Attribute::make(
            get: fn () => json_decode($this->body, true),
        );
    }
}
