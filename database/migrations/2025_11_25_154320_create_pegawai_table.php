<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->string('nip', 50)->unique();
            $table->string('nama_lengkap', 150);
            $table->string('jabatan', 100)->nullable();
            $table->string('departemen', 100)->nullable();

            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->date('tanggal_lahir')->nullable();

            $table->string('no_telepon', 20)->nullable();
            $table->text('alamat')->nullable();

            $table->date('tanggal_masuk')->nullable();
            $table->enum('status_kepegawaian', ['aktif', 'nonaktif', 'kontrak'])
                  ->default('aktif');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
