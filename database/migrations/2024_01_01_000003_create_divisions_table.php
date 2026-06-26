<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Divisions Table — Organisational Department / Division
     *
     * Used for multi-dimensional tagging on journal detail lines.
     * Examples: "Divisi Pemuda", "Humas", "Kaderisasi", "Organisasi"
     *
     * Enables cost-centre style reporting by division.
     */
    public function up(): void
    {
        Schema::create('divisions', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->string('name', 150);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('divisions');
    }
};
