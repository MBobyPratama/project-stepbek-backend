<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    /** @use HasFactory<\Database\Factories\HistoryFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id_tiket',
        'id_user',
        'id_event',
        'nama_event',
        'nomor_tiket',
        'metode_pembayaran',
        'total_pembayaran',
        'status_pembayaran',
        'tgl_pembayaran',
        'order_id',
    ];
}
