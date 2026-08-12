<?php
namespace App\Http\Controllers;

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

		return redirect()
			->route('tasks.show', $task)
			->with('success', 'Comment added.');
	}
}