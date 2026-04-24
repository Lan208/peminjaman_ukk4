<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->integer('denda_telat')->default(0)->after('jumlah');    // per hari
            $table->integer('denda_kerusakan')->default(0)->after('denda_telat'); // manual admin
            $table->integer('denda_total')->default(0)->after('denda_kerusakan');
            $table->string('kondisi_buku')->default('baik')->after('denda_total');
        });
    }

    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropColumn(['denda_telat', 'denda_kerusakan', 'denda_total']);
        });
    }
};
