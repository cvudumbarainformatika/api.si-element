<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surveyor extends Model
{
    use HasFactory, HasUuid;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class); // ini di tabel user gak ada pegawai_id nya
    }

    public function scopeFilter($search, array $reqs)
    {
        $search->when($reqs['q'] ?? false, function ($search, $query) {
            return $search->where('nama', 'LIKE', '%' . $query . '%')
                // ->orWhere('nip', 'LIKE', '%' . $query . '%')
                ->orWhere('nik', 'LIKE', '%' . $query . '%');
        });

        // $search->when($reqs['jenis_kepegawaian_id'] ?? false, function ($search, $query) {
        //     return $search->where('jenis_kepegawaian_id', $query);
        // });
    }
}
