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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->uuid('nomor_pembayaran');
            $table->integer('id_user');
            $table->integer('id_tiket');
            $table->foreign('id_tiket')->references('id')->on('tikets');
            $table->foreign('id_user')->references('id')->on('users');
            $table->string('metode_pembayaran');
            $table->integer('total_pembayaran');
            $table->enum('status_pembayaran', [
                'pending',
                'success',
                'cancel'
            ]);
            $table->date('tgl_pembayaran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
