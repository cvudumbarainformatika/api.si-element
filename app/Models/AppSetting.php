<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $casts = [
        'infos' => 'array',
        'themes' => 'array',
        'menus' => 'array',
    ];
}
