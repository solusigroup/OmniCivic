<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Budgets Table — Annual Budget Allocation
     *
     * Allows setting budget amounts per:
     *   Account  × Program × Division × Fiscal Year
     *
     * A unique composite constraint prevents duplicate budget entries
     * for the same combination. program_id and division_id are nullable
     * to allow budget allocation at account-only level.
     *
     * Budget vs Actual comparison is done by summing approved journal
     * details that match the account, program, and division combination.
     */
    public function up(): void
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('account_id')
                  ->constrained('chart_of_accounts')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            // Nullable — budget can be set at account level only
            $table->foreignId('program_id')
                  ->nullable()
                  ->constrained('programs')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();

            // Nullable — budget can be set without division specificity
            $table->foreignId('division_id')
                  ->nullable()
                  ->constrained('divisions')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();

            // Budget amount in IDR (Indonesian Rupiah)
            $table->decimal('amount', 20, 2)->default(0)
                  ->comment('Budget amount in IDR');

            // Fiscal year (e.g., 2024, 2025)
            $table->year('fiscal_year');

            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Prevent duplicate budget entries for the same combination
            $table->unique(
                ['account_id', 'program_id', 'division_id', 'fiscal_year'],
                'budgets_composite_unique'
            );

            $table->index('fiscal_year');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
