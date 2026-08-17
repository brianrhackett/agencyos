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
    	Schema::table('agency_users', function (Blueprint $table) {
            $table->dropColumn([
                'can_manage_clients',
                'can_manage_projects',
                'can_manage_tasks',
                'can_manage_files',
                'can_manage_team',
                'can_view_financials',
                'can_manage_settings',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agency_users', function (Blueprint $table) {
            Schema::table('agency_users', function (Blueprint $table) {
                $table->boolean('can_manage_clients')->default(false);
                $table->boolean('can_manage_projects')->default(false);
                $table->boolean('can_manage_tasks')->default(false);
                $table->boolean('can_manage_files')->default(false);
                $table->boolean('can_manage_team')->default(false);
                $table->boolean('can_view_financials')->default(false);
                $table->boolean('can_manage_settings')->default(false);
            });
        });
    }
};
