<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            // Make contact fields nullable for companies registered via interest form
            $table->string('contact_person')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('phone', 20)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            // Revert contact fields to NOT NULL
            $table->string('contact_person')->nullable(false)->change();
            $table->string('email')->nullable(false)->change();
            $table->string('phone', 20)->nullable(false)->change();
        });
    }
};
