<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'nomor_telepon' => '081234567890',
            'alamat' => 'Jl. Contoh No. 123',
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'user@example.com',
            'password' => bcrypt('string'),
            'role' => 'admin',
            'nomor_telepon' => '081234567890',
            'alamat' => 'Jl. Contoh No. 123',
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test2@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
            'nomor_telepon' => '081234567890',
            'alamat' => 'Jl. Contoh No. 123',
        ]);

        Event::create([
            'nama_event' => 'Workshop Pengembangan Data',
            'gambar' => null,
            'kategori' => 'workshop',
            'tema' => 'teknologi & digital',
            'deskripsi' => 'Workshop untuk belajar pengembangan web modern dengan Laravel dan React.',
            'nama_penyelenggara' => 'Tech Academy Indonesia',
            'tgl_listing' => Carbon::now(),
            'harga_tiket' => 1000,
            'kuota' => 50,
            'kota' => 'Jakarta',
            'tempat' => 'Tech Hub Jakarta, Lantai 5',
            'status_event' => 'upcoming',
            'tgl_mulai' => Carbon::now()->addDays(30),
            'tgl_selesai' => Carbon::now()->addDays(31),
            'kontak_penyelenggara' => 'contact@techacademy.id',
            'tipe_tiket' => 'berbayar',
        ]);

        Event::create([
            'nama_event' => 'Workshop Pengembangan Web',
            'gambar' => null,
            'kategori' => 'workshop',
            'tema' => 'teknologi & digital',
            'deskripsi' => 'Workshop untuk belajar pengembangan web modern dengan Laravel dan React.',
            'nama_penyelenggara' => 'Tech Academy Indonesia',
            'tgl_listing' => Carbon::now(),
            'harga_tiket' => 250000,
            'kuota' => 50,
            'kota' => 'Jakarta',
            'tempat' => 'Tech Hub Jakarta, Lantai 5',
            'status_event' => 'upcoming',
            'tgl_mulai' => Carbon::now()->addDays(30),
            'tgl_selesai' => Carbon::now()->addDays(31),
            'kontak_penyelenggara' => 'contact@techacademy.id',
            'tipe_tiket' => 'berbayar',
        ]);

        Event::create([
            'nama_event' => 'Seminar Kewirausahaan Digital',
            'gambar' => null,
            'kategori' => 'seminar',
            'tema' => 'bisnis & kewirausahaan',
            'deskripsi' => 'Seminar tentang strategi membangun bisnis digital yang berkelanjutan.',
            'nama_penyelenggara' => 'Business Innovation Center',
            'tgl_listing' => Carbon::now()->subDays(5),
            'harga_tiket' => 0,
            'kuota' => 100,
            'kota' => 'Surabaya',
            'tempat' => 'Grand Ballroom Hotel Majapahit',
            'status_event' => 'upcoming',
            'tgl_mulai' => Carbon::now()->addDays(15),
            'tgl_selesai' => Carbon::now()->addDays(15),
            'kontak_penyelenggara' => 'info@bic.co.id',
            'tipe_tiket' => 'gratis',
        ]);

        Event::create([
            'nama_event' => 'Kursus Public Speaking',
            'gambar' => null,
            'kategori' => 'kursus',
            'tema' => 'pengembangan diri & soft skills',
            'deskripsi' => 'Kursus intensif untuk meningkatkan kemampuan berbicara di depan umum.',
            'nama_penyelenggara' => 'Eloquent Speaker Academy',
            'tgl_listing' => Carbon::now()->subDays(10),
            'harga_tiket' => 500000,
            'kuota' => 30,
            'kota' => 'Bandung',
            'tempat' => 'Creative Hub Dago',
            'status_event' => 'ongoing',
            'tgl_mulai' => Carbon::now()->subDays(2),
            'tgl_selesai' => Carbon::now()->addDays(12),
            'kontak_penyelenggara' => 'course@eloquentspeaker.com',
            'tipe_tiket' => 'berbayar',
        ]);
    }
}
