<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidangSurvei extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function surveyor()
    {
        return $this->hasOne(Surveyor::class, 'bivei_id', 'id');
    }

    public function scopeFilter($search, array $reqs)
    {
        $search->when($reqs['q'] ?? false, function ($search, $query) {
            return $search->where('nama', 'LIKE', '%' . $query . '%');
        });
    }
}
