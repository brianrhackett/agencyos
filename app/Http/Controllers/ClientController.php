<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\StatsService;
use App\Models\Client;


class ClientController extends Controller
{
	public function index(StatsService $stats)
	{
        $summaryCards = [
            'totalClients' => [
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
                'title' => 'Tasks Awaiting Response',
                'value' => $stats->tasksInReview(),
            ]
        ];

        $clients = $this->_getClientsData();

        return view('clients.index', [
			'summaryCards' => $summaryCards,
            'clients' => $clients,
            'totalClientsCount' => $summaryCards['totalClients']['value']
        ]);
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address_line_one' => ['nullable', 'string', 'max:255'],
            'address_line_two' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string'],
            'is_active' => ['required', 'boolean'],
        ]);

        Client::create($validated);

        return redirect()
            ->route('clients.index')
            ->with('success', 'Client created successfully.');
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address_line_one' => ['nullable', 'string', 'max:255'],
            'address_line_two' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string'],
            'is_active' => ['required', 'boolean'],
        ]);

        $client->update($validated);

        return redirect()
            ->route('clients.index')
            ->with('success', 'Client updated successfully.');
    }

    public function show(Client $client)
    {
        return view('clients.show', compact('client'));
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()
            ->route('clients.index')
            ->with('success', 'Client deleted successfully.');
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
