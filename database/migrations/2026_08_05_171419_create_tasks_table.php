<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
			$table->id();

			$table->foreignId('project_id')
				->constrained()
				->cascadeOnDelete();

			$table->foreignId('milestone_id')
				->nullable()
				->constrained()
				->nullOnDelete();

			$table->foreignId('assigned_to')
				->nullable()
				->constrained('users')
				->nullOnDelete();

			$table->foreignId('created_by')
				->nullable()
				->constrained('users')
				->nullOnDelete();

			$table->string('title');
			$table->text('description')->nullable();

			$table->string('status')->default(TaskStatus::ToDo->value);
			$table->string('priority')->default(TaskPriority::Normal->value);

			$table->decimal('estimated_hours', 7, 2)->nullable();
			$table->decimal('actual_hours', 7, 2)->nullable();

			$table->date('start_date')->nullable();
			$table->date('due_date')->nullable();
			$table->timestamp('completed_at')->nullable();

			$table->timestamps();
			$table->softDeletes();

			$table->index(['project_id', 'status']);
			$table->index(['milestone_id', 'status']);
			$table->index(['assigned_to', 'status']);
			$table->index('due_date');
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
