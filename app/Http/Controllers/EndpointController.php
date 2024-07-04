<?php

namespace App\Http\Controllers;

use App\Models\Endpoint;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;

class EndpointController extends Controller
{
    public function relay($slug)
    {
        $endpoint = Endpoint::where([
            'slug' => $slug,
            'enabled' => 1,
        ])->firstOrFail();

        $targets = $endpoint->targets->filter(fn ($item) => $item->enabled);

        if ($targets->count() == 0) {
            abort(404);
        }

        $responses = Http::pool(function (Pool $pool) use ($targets) {
            return $targets->map(function($item) use ($pool) {
                return $pool->withHeaders($item->headersArray)->{strtolower($item->method)}($item->uri, array_merge($item->bodyArray, request()->all()));
            });
        });

        /** @var \Illuminate\Http\Client\Response */
        $response = current($responses);
        return response($response->body(), $response->status(), $response->headers());
    }
}
