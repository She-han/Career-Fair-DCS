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
            // Make user_id nullable since companies won't need to login
            $table->foreignId('user_id')->nullable()->change();
            
            // Add unique access token for secure CV viewing
            $table->string('access_token', 64)->unique()->after('user_id')->index();
            
            // Link to company participation response
            $table->foreignId('participation_response_id')->nullable()->after('access_token')
                ->constrained('company_participation_responses')->nullOnDelete();
            
            // Add token expiry (optional, can be null for no expiry)
            $table->timestamp('token_expires_at')->nullable()->after('access_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropForeign(['participation_response_id']);
            $table->dropColumn(['access_token', 'token_expires_at', 'participation_response_id']);
            
            // Revert user_id to required
            $table->foreignId('user_id')->nullable(false)->change();
        });
    }
};
