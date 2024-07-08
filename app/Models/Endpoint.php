<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Endpoint extends Model
{
	use HasDateTimeFormatter;    

    const enabled = [
        1 => "Yes",
        0 => "No",
    ];

    public function targets()
    {
        return $this->hasMany(EndpointTarget::class, 'endpoint_id', 'id');
    }

    public function url(): Attribute
    {
        return Attribute::make(
            get: fn() => sprintf("/api/endpoint/%s", $this->slug),
        );
    }

    public function titleAndUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => sprintf("/api/endpoint/%s - %s", $this->slug, $this->title),
        );
    }
}
