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
}
