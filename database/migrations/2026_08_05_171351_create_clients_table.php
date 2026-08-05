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
        Schema::create('clients', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->string('website')->nullable();
			$table->string('email')->nullable();
			$table->string('phone', 50)->nullable();

			$table->string('address_line_one')->nullable();
			$table->string('address_line_two')->nullable();
			$table->string('city')->nullable();
			$table->string('state', 100)->nullable();
			$table->string('postal_code', 20)->nullable();
			$table->string('country', 100)->default('United States');

			$table->text('notes')->nullable();
			$table->boolean('is_active')->default(true);

			$table->timestamps();
			$table->softDeletes();

			$table->index('name');
			$table->index('is_active');
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
