<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IzinBermalam extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'tanggal_berangkat' => $this->kepertanggal_berangkatluansurat,
            'tanggal_kembali' => $this->tanggal_kembali,
            'keperluan_ib' => $this->keperluan_ib,
            'tempat_tujuan' => $this->tempat_tujuan,
            'mahasiswa_id' => $this->mahasiswa_id,
            'status' => $this->status,
            'tanggal_approve' => $this->tanggal_approve,
        ];
    }
}
