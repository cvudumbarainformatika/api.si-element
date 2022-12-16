<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusKepegawaian extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function surveyor()
    {
        return $this->hasOne(Surveyor::class, 'stawai_id', 'id');
    }

    public function scopefilter($search, array $reqs)
    {
        $search->when($reqs['q'] ?? false, function ($search, $query) {
            return $search->where('nama', 'LIKE', '%' . $query . '%');
        });
    }
}
