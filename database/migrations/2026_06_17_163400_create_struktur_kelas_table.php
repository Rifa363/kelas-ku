<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('struktur_kelas', function (Blueprint $table) {
            $table->id();
            $table->string('jabatan');
            $table->foreignId('user_id')->constrained('mahasiswa')->cascadeOnDelete();
            $table->string('foto')->nullable();
            $table->integer('urutan')->default(0);
            $table->text('deskripsi')->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('struktur_kelas')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('struktur_kelas');
    }
};
