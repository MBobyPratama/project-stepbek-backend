<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Event extends Model
{
    /** @use HasFactory<\Database\Factories\EventFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama_event',
        'gambar',
        'kategori',
        'tema',
        'deskripsi',
        'nama_penyelenggara',
        'tgl_listing',
        'harga_tiket',
        'kuota',
        'kota',
        'tempat',
        'status_event',
        'tgl_mulai',
        'tgl_selesai',
        'kontak_penyelenggara',
        'tipe_tiket',
    ];

    // Add this accessor method
    protected function gambar(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? asset('storage/' . $value) : null,
        );
    }
}
