<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->string('role', 20)->default('anggota')->after('foto');
        });

        DB::statement("UPDATE mahasiswa SET role = 'admin' WHERE is_admin = 1");

        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->dropColumn('is_admin');
        });
    }

    public function down(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false);
        });

        DB::statement("UPDATE mahasiswa SET is_admin = 1 WHERE role = 'admin' OR role = 'administrator'");

        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
