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
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->integer('id_event');
            $table->integer('id_tiket')->nullable();
            $table->string('nama_event');
            $table->string('nomor_tiket');
            $table->string('metode_pembayaran');
            $table->integer('total_pembayaran');
            $table->enum('status_pembayaran', [
                'pending',
                'success',
                'cancel'
            ]);
            $table->date('tgl_pembayaran')->nullable();
            $table->string('order_id')->nullable()->after('tgl_pembayaran');
            $table->timestamps();

            $table->foreign('id_tiket')->references('id')->on('tikets');
            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_event')->references('id')->on('events');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histories');
    }
};
