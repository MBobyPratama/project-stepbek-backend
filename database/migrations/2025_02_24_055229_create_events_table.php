<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('nama_event');
            $table->string('gambar');
            $table->enum('kategori', [
                'seminar',
                'workshop',
                'kursus'
            ]);
            $table->enum('tema', [
                'keterampilan & kejuruan',
                'teknologi & digital',
                'bisnis & kewirausahaan',
                'pengembangan diri & soft skills'
            ]);
            $table->string('deskripsi');
            $table->string('nama_penyelenggara');
            $table->date('tlg_listing');
            $table->ineteger('harga_tiket');
            $table->integer('kuota');
            $table->string('kota');
            $table->string('tempat');
            $table->enum('status_event', [
                'upcoming',
                'ongoing',
                'complete',
                'canceled'
            ]);
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->string('kontak_penyelenggara');
            $table->enum('tipe_tiket', [
                'gratis',
                'berbayar'
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
