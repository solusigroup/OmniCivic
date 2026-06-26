<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Fund Sources Table — Source of Funds Classification (ISAK 35)
     *
     * Political party fund sources per Indonesian regulations:
     *   - government     → "Bantuan Negara / APBN"
     *   - member_contribution → "Iuran / Sumbangan Anggota"
     *   - donation        → "Sumbangan Pihak Ketiga"
     *   - other           → "Pendapatan Lain-lain"
     *
     * Links to equity/revenue classification under ISAK 35
     * (Penyajian Laporan Keuangan Entitas Berorientasi Nonlaba).
     */
    public function up(): void
    {
        Schema::create('fund_sources', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->string('name', 150);

            // Classification type per ISAK 35 and UU Parpol
            $table->enum('type', [
                'government',            // Bantuan Negara / APBN
                'member_contribution',   // Iuran Anggota
                'donation',              // Sumbangan Pihak Ketiga yang Sah
                'other',                 // Pendapatan Lain-lain
            ])->comment('Fund source classification per ISAK 35 / UU Parpol');

            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fund_sources');
    }
};
