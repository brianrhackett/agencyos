<?php

namespace App\Http\Controllers;

use App\Enums\ClientRole;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ClientUserController extends Controller
{
	public function create(Client $client)
	{
		return view('clients.users.create', [
			'client' => $client,
            'roles' => ClientRole::cases(),
            'role' => ''
        ]);
	}

	public function store(Request $request, Client $client)
	{
		$validated = $request->validate([
			'name' => ['required', 'string', 'max:255'],
			'email' => ['required', 'email', 'max:255', 'unique:users,email'],
			'job_title' => ['nullable', 'string', 'max:255'],
			'role' => ['required'],
			'is_primary_contact' => ['nullable', 'boolean'],
		]);

		$user = User::create([
			'name' => $validated['name'],
			'email' => $validated['email'],
			'password' => Hash::make(Str::random(32)),
		]);

		if ($validated['is_primary_contact'] ?? false) {
			$client->users()
				->wherePivot('is_primary_contact', true)
				->updateExistingPivot(
					$client->users()
						->wherePivot('is_primary_contact', true)
						->pluck('users.id'),
					['is_primary_contact' => false]
				);
			
			$client->update([
				'email' => $user->email,
			]);
		}

		$client->users()->attach($user->id, [
			'job_title' => $validated['job_title'] ?? null,
			'role' => $validated['role'] ?? null,
			'is_primary_contact' => $validated['is_primary_contact'] ?? false,
		]);

		Password::sendResetLink([
			'email' => $user->email,
		]);

		return redirect()
			->route('clients.show', $client)
			->with('success', 'Client user added.');
	}

	public function edit(Client $client, User $user)
	{
		$user = $client->users()
            ->whereKey($user->id)
            ->firstOrFail();

		return view('clients.users.edit', [
			'client' => $client, 
			'user' => $user,
			'roles' => ClientRole::cases(),
            'role' => $user->pivot->role,
		]);
	}

	public function update(Request $request, Client $client, User $user)
	{
		$this->_ensureUserBelongsToClient($client, $user);

		$validated = $request->validate([
			'name' => ['required', 'string', 'max:255'],
			'email' => [
				'required',
				'email',
				'max:255',
				Rule::unique('users', 'email')->ignore($user->id),
			],
			'job_title' => ['nullable', 'string', 'max:255'],
			'role' => ['nullable', 'string', 'max:255'],
			'is_primary_contact' => ['nullable', 'boolean'],
			'password' => ['nullable', 'string', 'min:8', 'confirmed'],
		]);

		$user->update([
			'name' => $validated['name'],
			'email' => $validated['email'],
		]);

		if (!empty($validated['password'])) {
			$user->update([
				'password' => Hash::make($validated['password']),
			]);
		}

		$client->users()->updateExistingPivot($user->id, [
			'job_title' => $validated['job_title'] ?? null,
			'role' => $validated['role'] ?? null,
			'is_primary_contact' => $validated['is_primary_contact'] ?? false,
		]);

		return redirect()
			->route('clients.show', $client)
			->with('success', 'Client user updated.');
	}

	public function destroy(Client $client, User $user)
	{
        abort_unless(auth()->user()->isAgencyUser(), 403);
        
		$this->_ensureUserBelongsToClient($client, $user);

		$client->users()->detach($user->id);

		$user->delete();

		return redirect()
			->route('clients.show', $client)
			->with('success', 'Client user deleted.');
	}

	public function projectOptions(Client $client)
	{
		$users = $client->users()
			->orderBy('name')
			->get();

		return response()->json(
			$users->map(fn ($user) => [
				'id' => $user->id,
				'name' => $user->name,
				'email' => $user->email,
				'is_primary_contact' => $user->pivot->is_primary_contact,
			])
		);
	}

	private function _ensureUserBelongsToClient(Client $client, User $user): void
	{
		abort_unless(
			$client->users()->whereKey($user->id)->exists(),
			404
		);
	}
}