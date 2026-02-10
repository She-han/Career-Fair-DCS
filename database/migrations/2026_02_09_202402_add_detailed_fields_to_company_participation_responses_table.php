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
        Schema::table('company_participation_responses', function (Blueprint $table) {
            $table->boolean('will_participate')->default(false)->after('message');
            $table->integer('expected_cvs')->nullable()->after('will_participate');
            $table->integer('intern_positions')->nullable()->after('expected_cvs');
            $table->json('vacant_positions')->nullable()->after('intern_positions');
            $table->json('preferred_languages')->nullable()->after('vacant_positions');
            $table->json('preferred_frameworks')->nullable()->after('preferred_languages');
            $table->string('preferred_timeslot')->nullable()->after('preferred_frameworks');
            $table->boolean('consent_to_receive_cvs')->default(false)->after('preferred_timeslot');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_participation_responses', function (Blueprint $table) {
            $table->dropColumn([
                'will_participate',
                'expected_cvs',
                'intern_positions',
                'vacant_positions',
                'preferred_languages',
                'preferred_frameworks',
                'preferred_timeslot',
                'consent_to_receive_cvs'
            ]);
        });
    }
};
