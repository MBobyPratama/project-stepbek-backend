<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    /** @use HasFactory<\Database\Factories\TiketFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nomor_tiket',
        'id_user',
        'id_event',
        'nama_event',
        'metode_pembayaran',
        'total_pembayaran',
        'status_pembayaran',
    ];
}
