<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Kaos extends JsonResource{
    public function toArray($request)
    {
        return[
            'ukuran' => $this ->ukuran,
            'kode_ukuran' => $this ->kode_ukuran,
            'stok' => $this ->stok,
            'harga' => $this ->harga,
        ];

        
    }
}


?>