<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'gambar' => $this->gambar,
            'nama_event' => $this->nama_event,
            'kategori' => $this->kategori,
            'tema' => $this->tema,
            'deskripsi' => $this->deskripsi,
            'nama_penyelenggara' => $this->nama_penyelenggara,
            'tgl_listing' => $this->tgl_listing,
            'harga_tiket' => $this->harga_tiket,
            'kuota' => $this->kuota,
            'tempat' => $this->tempat,
            'status_event' => $this->status_event,
            'tgl_mulai' => $this->tgl_mulai,
            'tgl_selesai' => $this->tgl_selesai,
            'kontak_penyelenggara' => $this->kontak_penyelenggara,
            'tipe_tiket' => $this->tipe_tiket,
        ];
    }
}
