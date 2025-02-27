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
        Schema::create('tikets', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_tiket');
            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_event')->references('id')->on('events');
            $table->string('nama_event');
            $table->string('metode_pembayaran');
            $table->integer('total_pembayaran');
            $table->enum('status_pembayaran', [
                'pending',
                'success',
                'cancel'
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tikets');
    }
};
