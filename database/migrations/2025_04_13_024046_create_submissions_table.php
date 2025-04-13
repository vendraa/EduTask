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
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained('assignments')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->string('file'); // file tugas yang diunggah
            $table->timestamp('submitted_at'); // waktu pengumpulan
            $table->timestamps();
    
            $table->unique(['assignment_id', 'student_id']); // hanya boleh 1 kali pengumpulan per tugas per mahasiswa
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign key constraints first
        Schema::table('submissions', function (Blueprint $table) {
            $table->dropForeign(['assignment_id']); // Menghapus foreign key constraint untuk kolom assignment_id
            $table->dropForeign(['student_id']); // Menghapus foreign key constraint untuk kolom student_id
        });
    
        // Drop the table after dropping foreign key constraints
        Schema::dropIfExists('submissions');
    }    
};
