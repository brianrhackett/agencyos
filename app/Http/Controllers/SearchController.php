<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\File;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Models\Milestone;
use Illuminate\Http\Request;

class SearchController extends Controller
{
	public function index(Request $request)
	{
		$search = $request->input('search');

		$clients = collect();
		$projects = collect();
        $milestones = collect();
		$tasks = collect();
		$files = collect();
		$users = collect();

		if ($search) {
			$clients = Client::where('name', 'ilike', "%{$search}%")
				->limit(10)
				->get();

			$projects = Project::where('name', 'ilike', "%{$search}%")
				->limit(10)
				->get();

            $milestones = Milestone::where('name', 'ilike', "%{$search}%")
				->limit(10)
				->get();

			$tasks = Task::where('title', 'ilike', "%{$search}%")
				->limit(10)
				->get();

			$files = File::where('original_name', 'ilike', "%{$search}%")
				->limit(10)
				->get();

			$users = User::where('name', 'ilike', "%{$search}%")
				->limit(10)
				->get();
		}

		return view('search.index', compact(
			'search',
			'clients',
			'projects',
            'milestones',
			'tasks',
			'files',
			'users'
		));
	}
}