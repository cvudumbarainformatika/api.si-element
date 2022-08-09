<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SurveyorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'user_id' => $this->user_id,
            'nik' => $this->nik,
            'no_hp' => $this->no_hp,
            'nama' => $this->nama,
            'alamat' => $this->alamat,
            'provinsi' => $this->provinsi,
            'kabkot' => $this->kabkot,
            'kecamatan' => $this->kecamatan,
            'kelurahan' => $this->kelurahan,
            'kodepos' => $this->kodepos,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir,
            'gender' => $this->gender,
            'agama' => $this->agama,
            'flag' => $this->flag,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
