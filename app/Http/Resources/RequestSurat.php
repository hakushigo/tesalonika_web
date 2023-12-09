<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RequestSurat extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'keperluansurat' => $this->keperluansurat,
            'deskripsi' => $this->deskripsi,
            'tanggal_pengajuan' => $this->tanggal_pengajuan,
            'tanggal_pengambilan' => $this->tanggal_pengambilan,
            'mahasiswa_id' => $this->mahasiswa_id,
            'status' => $this->status,
            'tanggal_approve' => $this->tanggal_approve,
        ];
    }
}

?>