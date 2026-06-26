<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Chart of Accounts Table — Bagan Akun Standar (BAS)
     *
     * Standard 5-type classification:
     *   1. Asset      (Aset)
     *   2. Liability  (Liabilitas)
     *   3. Equity     (Aset Neto) — mapped to ISAK 35 net assets
     *   4. Revenue    (Pendapatan)
     *   5. Expense    (Beban)
     *
     * restriction_type maps to ISAK 35 net asset presentation:
     *   - unrestricted              → Tanpa Pembatasan
     *   - temporarily_restricted    → Dengan Pembatasan Temporer
     *   - permanently_restricted    → Dengan Pembatasan Permanen
     *
     * The code field supports hierarchical numbering (e.g., "1-1000" for Cash,
     * "4-1000" for Revenue from Government Grants).
     */
    public function up(): void
    {
        Schema::create('chart_of_accounts', function (Blueprint $table) {
            $table->id();

            // Hierarchical account code (e.g., "1-1000", "4-2000")
            $table->string('code', 20)->unique();

            $table->string('name', 200);

            // Standard accounting type
            $table->enum('type', [
                'asset',
                'liability',
                'equity',
                'revenue',
                'expense',
            ])->comment('Standard accounting classification');

            // ISAK 35 — Net asset restriction classification
            // Applicable primarily to equity and revenue accounts
            $table->enum('restriction_type', [
                'unrestricted',              // Tanpa Pembatasan
                'temporarily_restricted',    // Dengan Pembatasan Temporer
                'permanently_restricted',    // Dengan Pembatasan Permanen
            ])->default('unrestricted')
              ->comment('ISAK 35 net asset restriction classification');

            // Identifies if this is a Cash or Bank account (for cash-basis transactions)
            $table->boolean('is_cash_or_bank')->default(false)
                  ->comment('True for accounts usable as Cash/Bank in cash-basis entries');

            // Normal balance direction for validation
            $table->enum('normal_balance', ['debit', 'credit'])->default('debit')
                  ->comment('Expected normal balance direction');

            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('type');
            $table->index('is_cash_or_bank');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chart_of_accounts');
    }
};
