<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Journals Table — Transaction Header / Journal Entry
     *
     * Core of the cash-basis double-entry system.
     *
     * Transaction Types:
     *   - cash_in   → Cash receipt (Debit: Cash/Bank, Credit: Revenue)
     *   - cash_out  → Cash disbursement (Debit: Expense, Credit: Cash/Bank)
     *   - transfer  → Internal transfer (Debit: Destination, Credit: Origin)
     *
     * Approval Workflow:
     *   draft → reviewed → approved   (happy path)
     *   draft → reviewed → rejected   (rejection path)
     *   draft → rejected              (early rejection)
     *
     * Only 'approved' journals impact financial reports.
     * Every journal is tagged with a branch_id for multi-branch reporting.
     */
    public function up(): void
    {
        Schema::create('journals', function (Blueprint $table) {
            $table->id();

            // Branch association for consolidated reporting
            $table->foreignId('branch_id')
                  ->constrained('branches')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            // Transaction classification
            $table->enum('transaction_type', ['cash_in', 'cash_out', 'transfer'])
                  ->comment('Type of cash-basis transaction');

            $table->date('transaction_date');

            // Auto-generated or manual reference number
            $table->string('reference_number', 50)->unique();

            $table->text('description')->nullable();

            // Approval workflow status
            $table->enum('status', ['draft', 'reviewed', 'approved', 'rejected'])
                  ->default('draft')
                  ->comment('Approval workflow state');

            // Rejection reason (populated when status = rejected)
            $table->text('rejection_reason')->nullable();

            // Audit trail: who created, reviewed, approved
            $table->foreignId('created_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->foreignId('reviewed_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->foreignId('approved_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            // Timestamps for when status transitions happened
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamp('approved_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Performance indexes for common queries
            $table->index('transaction_date');
            $table->index('status');
            $table->index('branch_id');
            $table->index(['status', 'transaction_date']);  // For report queries
            $table->index(['branch_id', 'status']);          // For branch-specific reports
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('journals');
    }
};
