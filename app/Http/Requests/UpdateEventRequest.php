<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_event' => 'sometimes|string|max:255',
            'gambar' => 'sometimes|string',
            'kategori' => 'sometimes|string',
            'tema' => 'sometimes|string',
            'deskripsi' => 'sometimes|string',
            'nama_penyelenggara' => 'sometimes|string',
            'tgl_listing' => 'sometimes|date',
            'harga_tiket' => 'sometimes|numeric',
            'kuota' => 'sometimes|integer',
            'kota' => 'sometimes|string',
            'tempat' => 'sometimes|string',
            'status_event' => 'sometimes|string',
            'tgl_mulai' => 'sometimes|date',
            'tgl_selesai' => 'sometimes|date',
            'kontak_penyelenggara' => 'sometimes|string',
            'tipe_tiket' => 'sometimes|string'
        ];
    }
}
