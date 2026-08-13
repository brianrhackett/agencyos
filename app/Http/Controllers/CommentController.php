<?php
namespace App\Http\Controllers;

use App\Services\ActivityLogger;

use App\Models\Task;
use Illuminate\Http\Request;

class CommentController extends Controller
{
	public function store(Request $request, Task $task)
	{
		$validated = $request->validate([
			'body' => ['required', 'string', 'max:5000'],
		]);

		$task->comments()->create([
			'user_id' => auth()->id(),
			'body' => $validated['body'],
		]);

		ActivityLogger::log(
            'task.commented',
            $task,
            [
                'task_name' => $task->title,
                'project_name' => $task->project->name,
                'milestone_name' => $task->milestone?->name,
                'client_name' => $task->project->client->name,
            ]
        );

		return redirect()
			->route('tasks.show', $task)
			->with('success', 'Comment added.');
	}
}