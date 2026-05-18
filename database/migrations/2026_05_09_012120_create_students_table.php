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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('nisn')->unique()->comment('Nomor Induk Siswa Nasional');
            $table->string('nama')->comment('Nama lengkap siswa');
            $table->string('kelas')->comment('Kelas siswa, misal: XI RPL 2');
            $table->string('rfid_uid')->unique()->nullable()->comment('Kode dari ID Card RFID');
            $table->string('photo_path')->nullable()->comment('Lokasi penyimpanan file foto visual');
            $table->json('face_descriptor')->nullable()->comment('Data titik wajah untuk AI (array)');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
