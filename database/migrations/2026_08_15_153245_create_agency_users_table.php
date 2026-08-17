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
        Schema::create('agency_users', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->unique()
                ->constrained()
                ->cascadeOnDelete();

            $table->string('role')->nullable();

            $table->boolean('can_manage_clients')->default(false);
            $table->boolean('can_manage_projects')->default(false);
            $table->boolean('can_manage_tasks')->default(false);
            $table->boolean('can_manage_files')->default(false);
            $table->boolean('can_manage_team')->default(false);
            $table->boolean('can_view_financials')->default(false);
            $table->boolean('can_manage_settings')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agency_users');
    }
};
