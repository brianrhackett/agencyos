<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Enums\ProjectPriority;
use App\Enums\ProjectStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
		Schema::create('projects', function (Blueprint $table) {
			$table->id();

			$table->foreignId('client_id')
				->constrained()
				->restrictOnDelete();

			$table->foreignId('project_manager_id')
				->nullable()
				->constrained('users')
				->nullOnDelete();

			$table->string('name');
			$table->string('slug')->unique();
			$table->text('description')->nullable();

			$table->string('status')->default(ProjectStatus::Planning->value);
			$table->string('priority')->default(ProjectPriority::Normal->value);

			$table->decimal('budget', 12, 2)->nullable();

			$table->date('start_date')->nullable();
			$table->date('due_date')->nullable();
			$table->timestamp('completed_at')->nullable();
			$table->timestamp('archived_at')->nullable();

			$table->timestamps();
			$table->softDeletes();

			$table->index(['client_id', 'status']);
			$table->index('due_date');
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
