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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel students menggunakan student_id
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            
            // Waktu presensi dilakukan
            $table->dateTime('scanned_at');
            
            // Status kehadiran (misal: 'Hadir' atau 'Valid')
            $table->string('status')->default('Valid');
            
            // Opsional: Menyimpan skor kemiripan wajah dari AI (0.0 sampai 1.0)
            $table->float('confidence_score')->nullable();
            
            // Opsional: Jika kamu ingin menyimpan foto snapshot saat siswa scan (untuk bukti)
            $table->string('verify_photo_path')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
