<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CertificateResource extends JsonResource
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
            'nomor_sertifikat' => $this->nomor_sertifikat,
            'nama_user' => $this->nama_user,
            'nama_event' => $this->nama_event,
        ];
    }
}
