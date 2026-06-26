<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add identity_settings JSON column to branches table
     */
    public function up(): void
    {
        Schema::table('branches', function (Blueprint $table) {
            $table->json('identity_settings')
                  ->after('name')
                  ->nullable()
                  ->comment('Stores party_name, branch_display_name, logo_party_path, logo_branch_path, address, phone, email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('branches', function (Blueprint $table) {
            $table->dropColumn('identity_settings');
        });
    }
};
