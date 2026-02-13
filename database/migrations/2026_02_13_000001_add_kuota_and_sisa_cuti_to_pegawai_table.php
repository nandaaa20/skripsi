<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pegawai', function (Blueprint $table) {
            $table->integer('kuota_cuti')->default(12)->after('status_kepegawaian');
            $table->integer('sisa_cuti')->default(12)->after('kuota_cuti');
        });

        DB::table('pegawai')->update([
            'sisa_cuti' => DB::raw('kuota_cuti'),
        ]);
    }

    public function down(): void
    {
        Schema::table('pegawai', function (Blueprint $table) {
            $table->dropColumn(['kuota_cuti', 'sisa_cuti']);
        });
    }
};
