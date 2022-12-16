<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surveyor extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function bidangSurvei()
    {
        return $this->belongsTo(BidangSurvei::class, 'bivei_id');
    }
    public function statusKepegawaian()
    {
        return $this->belongsTo(StatusKepegawaian::class, 'stawai_id');
    }
    public function provesi()
    {
        return $this->belongsTo(Provesi::class, 'provesi_id');
    }

    public function scopeFilter($search, array $reqs)
    {
        $search->when($reqs['q'] ?? false, function ($search, $query) {
            return $search->where('nama_lengkap', 'LIKE', '%' . $query . '%');
        });
    }
}
