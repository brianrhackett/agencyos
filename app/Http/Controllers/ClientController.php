<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

use App\Services\StatsService;
use App\Models\Client;
use App\Models\User;

class ClientController extends Controller
{
	public function index(StatsService $stats, Request $request)
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

        $clients = $this->_getClientsData($request);

        return view('clients.index', [
			'summaryCards' => $summaryCards,
            'clients' => $clients,
            'totalClientsCount' => $summaryCards['totalClients']['value']
        ]);
    }

    public function create()
    {
        $this->authorize('create', Client::class);

        return view('clients.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Client::class);

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

        $user_validated = $request->validate([
            'primary_contact_name' => ['required', 'string', 'max:255'],
        ]);

        [$client, $user] = DB::transaction(function () use ($validated, $user_validated) {
            $client = Client::create($validated);

            $user = User::create([
                'name' => $user_validated['primary_contact_name'],
                'email' => $validated['email'],
                'password' => Hash::make(Str::random(32)),
            ]);

            $client->users()->attach($user->id, [
                'is_primary_contact' => true,
                'role' => 'administrator',
            ]);

            return [$client, $user];
        });

        $user->sendPasswordResetNotification(
            Password::createToken($user)
        );

        return redirect()
            ->route('clients.show', $client)
            ->with('success', 'Client created successfully.');
    }

    public function edit(Client $client)
    {
        $this->authorize('update', Client::class);

        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $this->authorize('update', Client::class);

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
        $this->authorize('view', Client::class);

        $client->load([
            'users',
            'projects',
        ]);
        return view('clients.show', compact('client'));
    }

    public function destroy(Client $client)
    {
        $this->authorize('delete', Client::class);

        $client->delete();

        return redirect()
            ->route('clients.index')
            ->with('success', 'Client deleted successfully.');
    }

    private function _getClientsData($request)
    {
        $query = Client::with('primaryContact')
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'ilike', "%{$search}%");
            })
            ->when($request->filled('is_active'), function ($query) use ($request) {
                $query->where('is_active', $request->is_active);
            })
            ->withCount([
                'projects as active_projects_count' => function ($query) {
                    $query->where('status', 'active');
                }
            ]);
            
        return $query->paginate(5)->withQueryString();
    }

    
}
