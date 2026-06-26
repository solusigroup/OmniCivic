<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Programs Table — Activity / Program Classification
     *
     * Used for multi-dimensional tagging on journal detail lines.
     * Examples: "Kampanye Akbar", "Bakti Sosial", "Musyawarah Nasional"
     *
     * Enables reporting by program/activity across all branches
     * to track how funds are allocated to specific party activities.
     */
    public function up(): void
    {
        Schema::create('programs', function (Blueprint $table) {
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
        Schema::dropIfExists('programs');
    }
};
