<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Enums\MilestoneStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('milestones', function (Blueprint $table) {
			$table->id();

			$table->foreignId('project_id')
				->constrained()
				->cascadeOnDelete();

			$table->string('name');
			$table->text('description')->nullable();

			$table->string('status')->default(MilestoneStatus::NotStarted->value);
			$table->unsignedInteger('sort_order')->default(0);

			$table->date('start_date')->nullable();
			$table->date('due_date')->nullable();
			$table->timestamp('completed_at')->nullable();

			$table->timestamps();

			$table->index(['project_id', 'status']);
			$table->index(['project_id', 'sort_order']);
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('milestones');
    }
};
