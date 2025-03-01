<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
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
            'nama_event' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:3048',
            'kategori' => 'required|string|in:seminar,workshop,kursus',
            'tema' => 'required|string|in:keterampilan & kejuruan,teknologi & digital,bisnis & kewirausahaan,pengembangan diri & soft skills',
            'deskripsi' => 'required|string',
            'nama_penyelenggara' => 'required|string',
            'tgl_listing' => 'required|date',
            'harga_tiket' => 'required|integer',
            'kuota' => 'required|integer',
            'kota' => 'required|string',
            'tempat' => 'required|string',
            'status_event' => 'required|string|in:upcoming,ongoing,complete,canceled',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date',
            'kontak_penyelenggara' => 'required|string',
            'tipe_tiket' => 'required|string|in:gratis,berbayar'
        ];
    }
}
