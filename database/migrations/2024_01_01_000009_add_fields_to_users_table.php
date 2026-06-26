<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Update users table to add:
     * - branch_id (foreign key, nullable for Super Admin)
     * - role (enum: staff, bendahara, ketua, super_admin)
     * - status (enum: active, inactive)
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('branch_id')
                  ->after('id')
                  ->nullable()
                  ->constrained('branches')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();

            $table->enum('role', ['staff', 'bendahara', 'ketua', 'super_admin'])
                  ->after('email')
                  ->default('staff')
                  ->comment('staff=Staff Akuntansi, bendahara=Bendahara, ketua=Ketua, super_admin=Super Admin');

            $table->enum('status', ['active', 'inactive'])
                  ->after('role')
                  ->default('active');
            
            $table->softDeletes();
            
            $table->index('role');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropColumn(['branch_id', 'role', 'status', 'deleted_at']);
        });
    }
};
