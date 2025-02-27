<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PembayaranResource extends JsonResource
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
            'id_tiket' => $this->id_tiket,
            'nomor_pembayaran' => $this->nomor_pembayaran,
            'metode_pembayaran' => $this->metode_pembayaran,
            'total_pembayaran' => $this->total_pembayaran,
            'status_pembayaran' => $this->status_pembayaran,
            'tgl_pembayaran' => $this->tgl_pembayaran,
        ];
    }
}
