<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Ruangan extends JsonResource{
    public function toArray($request)
    {
        return[
            'id' => $this->id,
            'nama' => $this->nama,
        ];
        
    }
}


?>