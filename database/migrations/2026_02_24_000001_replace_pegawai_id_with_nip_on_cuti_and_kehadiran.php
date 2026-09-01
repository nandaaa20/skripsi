<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cuti', function (Blueprint $table) {
            $table->string('nip', 50)->nullable()->after('id');
        });

        Schema::table('kehadiran', function (Blueprint $table) {
            $table->string('nip', 50)->nullable()->after('id');
        });

        DB::statement('UPDATE cuti c JOIN pegawai p ON c.pegawai_id = p.id SET c.nip = p.nip');
        DB::statement('UPDATE kehadiran k JOIN pegawai p ON k.pegawai_id = p.id SET k.nip = p.nip');

        Schema::table('cuti', function (Blueprint $table) {
            $table->dropForeign(['pegawai_id']);
            $table->dropColumn('pegawai_id');
            $table->string('nip', 50)->nullable(false)->change();
            $table->foreign('nip')->references('nip')->on('pegawai')->onDelete('cascade');
        });



    Schema::table('kehadiran', function (Blueprint $table) {
        $table->dropForeign(['pegawai_id']);
        $table->dropUnique(['pegawai_id', 'tanggal']);
        $table->dropColumn('pegawai_id');
        $table->string('nip', 50)->nullable(false)->change();
        $table->foreign('nip')->references('nip')->on('pegawai')->onDelete('cascade');
        $table->unique(['nip', 'tanggal']);
    });
    }

    public function down(): void
    {
        Schema::table('cuti', function (Blueprint $table) {
            $table->foreignId('pegawai_id')->nullable()->after('id');
        });

        Schema::table('kehadiran', function (Blueprint $table) {
            $table->dropForeign(['nip']);
            $table->dropUnique(['nip', 'tanggal']);

            $table->dropColumn('nip');

            $table->unsignedBigInteger('pegawai_id')->nullable(false)->change();
            $table->foreign('pegawai_id')->references('id')->on('pegawai')->onDelete('cascade');
            $table->unique(['pegawai_id', 'tanggal']);
        });

        DB::statement('UPDATE cuti c JOIN pegawai p ON c.nip = p.nip SET c.pegawai_id = p.id');
        DB::statement('UPDATE kehadiran k JOIN pegawai p ON k.nip = p.nip SET k.pegawai_id = p.id');

        Schema::table('cuti', function (Blueprint $table) {
            $table->dropForeign(['nip']);
            $table->dropColumn('nip');
            $table->unsignedBigInteger('pegawai_id')->nullable(false)->change();
            $table->foreign('pegawai_id')->references('id')->on('pegawai')->onDelete('cascade');
        });

        Schema::table('kehadiran', function (Blueprint $table) {
            $table->dropUnique(['nip', 'tanggal']);
            $table->dropForeign(['nip']);
            $table->dropColumn('nip');
            $table->unsignedBigInteger('pegawai_id')->nullable(false)->change();
            $table->foreign('pegawai_id')->references('id')->on('pegawai')->onDelete('cascade');
            $table->unique(['pegawai_id', 'tanggal']);
        });
    }
};
