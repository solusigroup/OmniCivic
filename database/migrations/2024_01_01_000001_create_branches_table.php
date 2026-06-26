<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Branches Table — Political Party Territorial / Branch Hierarchy
     *
     * Supports a self-referencing 4-tier structure:
     *   DPP  (Dewan Pimpinan Pusat)         — National / Central
     *   DPD  (Dewan Pimpinan Daerah)        — Province level
     *   DPC  (Dewan Pimpinan Cabang)         — Regency / City level
     *   PAC  (Pimpinan Anak Cabang)          — District / Sub-district level
     *
     * Every financial transaction (journal) is tagged with a branch_id
     * to enable consolidated and branch-specific reporting.
     */
    public function up(): void
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();

            // Self-referencing parent for hierarchy traversal
            $table->foreignId('parent_id')
                  ->nullable()
                  ->constrained('branches')
                  ->nullOnDelete();

            // Tier enforces the 4-level hierarchy
            $table->enum('tier', ['dpp', 'dpd', 'dpc', 'pac'])
                  ->comment('DPP=National, DPD=Province, DPC=Regency/City, PAC=District');

            // Unique organisational code (e.g. "DPP-001", "DPD-JABAR-001")
            $table->string('code', 30)->unique();

            // Human-readable name (e.g. "DPP Partai XYZ", "DPD Jawa Barat")
            $table->string('name', 150);

            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            // Index for hierarchy queries
            $table->index('parent_id');
            $table->index('tier');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
