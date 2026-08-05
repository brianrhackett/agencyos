<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Enums\ClientRole;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('client_user', function (Blueprint $table) {
			$table->id();

			$table->foreignId('client_id')
				->constrained()
				->cascadeOnDelete();

			$table->foreignId('user_id')
				->constrained()
				->cascadeOnDelete();

			$table->string('role')->default(ClientRole::Member->value);
			$table->string('job_title')->nullable();
			$table->boolean('is_primary_contact')->default(false);

			$table->timestamps();

			$table->unique(['client_id', 'user_id']);
			$table->index(['client_id', 'is_primary_contact']);
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_user');
    }
};
