<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TiketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'id_user' => $this->id_user,
            'id_event' => $this->id_event,
            'nomor_tiket' => $this->nomor_tiket,
            'nama_event' => $this->nama_event,
            'nama_user' => $this->nama_user,
            'metode_pembayaran' => $this->metode_pembayaran,
            'total_pembayaran' => $this->total_pembayaran,
            'status_pembayaran' => $this->status_pembayaran,
        ];
    }
}
