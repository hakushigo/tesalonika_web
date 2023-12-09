<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SuratIK extends JsonResource
{
    public function toArray($request)
    {
        return[
            'id'=>$this->id,
            'rencana_berangkat'=>$this->rencana_berangkat,
            'rencana_kembali'=>$this->rencana_kembali,
            'keperluan_ik'=>$this->keperluan_ik,
            'mahasiswa_id'=>$this->mahasiswa_id,
            'status'=>$this->status,
            'tanggal_approve'=>$this->tanggal_approve,
        ];
    }
}

?>

