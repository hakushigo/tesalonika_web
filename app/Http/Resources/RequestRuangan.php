<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RequestRuangan extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'mahasiswa' => $this->mahasiswa,
            'ruangan_id' => $this->ruangan_id,
            'tanggal_terima' => $this->tanggal_terima,
            'status' => $this->status,
            'keterangan' => $this->keterangan,
            'start_time' => $this->start_time,
            'end_time'=>$this->end_time
        ];
    }
}
