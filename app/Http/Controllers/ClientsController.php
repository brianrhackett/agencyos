<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\StatsService;
use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use App\Models\Milestone;
use App\Models\Activity;

class ClientsController extends Controller
{
	public function index(StatsService $stats)
	{
        $summaryCards = [
            [
                'title' => 'Total Clients',
                'value' => $stats->totalClients(),
            ],
            [
                'title' => 'Active Clients',
                'value' => $stats->activeClients(),
            ],
            [
                'title' => 'Active Projects',
                'value' => $stats->activeProjects(),
            ],
            [
                'title' => 'Awaiting Response',
                'value' => $stats->tasksInReview(),
            ]
        ];

        $clients = $this->_getClientsData();

        return view('clients.index', [
			'summaryCards' => $summaryCards,
            'clients' => $clients
        ]);
    }

    private function _getClientsData()
    {
        return Client::with('primaryContact')
            ->withCount([
                'projects as active_projects_count' => function ($query) {
                    $query->where('status', 'active');
                }
            ])
            ->paginate(5);
    }
}
