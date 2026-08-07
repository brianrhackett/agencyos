<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Client;
use App\Models\Project;
use App\Models\Task;

class DashboardController extends Controller
{
	public function index()
	{
        $summaryCards = [
            [
                'title' => 'Total Clients',
                'value' => Client::count(),
            ],
            [
                'title' => 'Active Projects',
                'value' => Project::where('status', 'active')->count(),
            ],
            [
                'title' => 'Tasks Due Today',
                'value' => Task::whereDate('due_date', today())
                    ->where('status', '!=', 'completed')
                    ->count(),
            ],
            [
                'title' => 'Awaiting Approval',
                'value' => Task::where('status', 'awaiting_approval')->count(),
            ],
        ];
		return view('dashboard', [
			'summaryCards' => $summaryCards
		]);
	}
}