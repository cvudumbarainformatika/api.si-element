<?php
namespace App\Models\Traits;

use Illuminate\Support\Str;

Trait HasUuid
{
    protected static function bootHasUuid()
    {   
        // parent::boot();

        static::creating(function($model){
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid();
            }
        });
    }
}