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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('start_date'); 
            $table->dateTime('deadline');   
            $table->string('file')->nullable();
            $table->string('status')->default('scheduled'); 
            $table->foreignId('lecturer_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the foreign key constraint for lecturer_id
        Schema::table('assignments', function (Blueprint $table) {
            $table->dropForeign(['lecturer_id']); // Menghapus foreign key constraint untuk kolom lecturer_id
        });
    
        // Drop the table after dropping the foreign key constraint
        Schema::dropIfExists('assignments');
    }    
};
