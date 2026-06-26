<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Journal Details Table — Double-Entry Line Items
     *
     * Each journal entry has 2+ detail lines that must balance:
     *   SUM(debit) == SUM(credit)
     *
     * Multi-dimensional tagging (all optional):
     *   - program_id    → Links to activity/program
     *   - division_id   → Links to organisational division
     *   - fund_source_id → Links to fund source (ISAK 35 classification)
     *
     * These dimensions enable granular financial reporting by
     * any combination of account × program × division × fund source.
     */
    public function up(): void
    {
        Schema::create('journal_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('journal_id')
                  ->constrained('journals')
                  ->cascadeOnDelete();

            $table->foreignId('account_id')
                  ->constrained('chart_of_accounts')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            // Double-entry amounts — at least one must be > 0, the other = 0
            $table->decimal('debit', 20, 2)->default(0);
            $table->decimal('credit', 20, 2)->default(0);

            // ----- Multi-Dimensional Tags (all optional) -----

            $table->foreignId('program_id')
                  ->nullable()
                  ->constrained('programs')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();

            $table->foreignId('division_id')
                  ->nullable()
                  ->constrained('divisions')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();

            $table->foreignId('fund_source_id')
                  ->nullable()
                  ->constrained('fund_sources')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();

            $table->text('notes')->nullable();
            $table->timestamps();

            // Performance indexes for report aggregation queries
            $table->index('journal_id');
            $table->index('account_id');
            $table->index('program_id');
            $table->index('division_id');
            $table->index('fund_source_id');

            // Composite index for common report queries
            $table->index(['account_id', 'program_id', 'division_id'], 'jd_report_composite');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('journal_details');
    }
};
