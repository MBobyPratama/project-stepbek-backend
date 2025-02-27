<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HistoryResource extends JsonResource
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
            'id_tiket' => $this->id_tiket,
            'id_tiket' => $this->id_tiket,
            'id_event' => $this->id_event,
            'nama_event' => $this->nama_event,
            'nomor_tiket' => $this->nomor_tiket,
            'metode_pembayaran' => $this->metode_pembayaran,
            'total_pembayaran' => $this->total_pembayaran,
            'status_pembayaran' => $this->status_pembayaran,
            'tgl_pembayaran' => $this->tgl_pembayaran,
        ];
    }
}
