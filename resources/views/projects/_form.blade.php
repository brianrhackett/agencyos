@php
	$teamRoles = isset($project)
		? $project->teamMembers->mapWithKeys(fn ($member) => [
			$member->id => $member->pivot->role->value,
		])
		: collect();
@endphp

<div class="space-y-6">
	<x-select
		name="client_id"
		label="Client"
		required
		:disabled="isset($project)"
	>
		<option value="">Select a client</option>

		@foreach ($clients as $clientOption)
			<option
				value="{{ $clientOption->id }}"
				@selected(old('client_id', $project->client_id ?? '') == $clientOption->id)
			>
				{{ $clientOption->name }}
			</option>
		@endforeach
	</x-select>

	<x-input
		name="name"
		label="Project Name"
		value="{{ old('name', $project->name ?? '') }}"
		required
	/>

	<x-textarea
		name="description"
		label="Description"
	>{{ old('description', $project->description ?? '') }}</x-textarea>

	<div>
		<div class="mt-2 space-y-2">
			<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
				<div>
					<h3 class="font-bold text-lg">Agency Team</h3>
					<p class="my-4 text-sm text-stone-500 dark:text-stone-400">Select agency team members and their role on this project.</p>
					<div class="overflow-hidden rounded-sm border border-stone-200 min-w-full border-1 border-stone-200 rounded-sm dark:divide-stone-800">
						<table class="border-collapse w-full divide-y">
							<thead class="bg-stone-50 dark:bg-stone-900">
								<th
									scope="col"
									class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-stone-500 dark:text-stone-400"
								>
									Team Member
								</th>
								<th
									scope="col"
									class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-stone-500 dark:text-stone-400"
								>    
									Role on Project
								</th>
							</thead>
							<tbody class="divide-y divide-stone-200 bg-white dark:divide-stone-800 dark:bg-stone-950">
								@foreach ($agencyUsers as $user)
									<tr class="transition-colors hover:bg-stone-50 dark:hover:bg-stone-900">
										<td class="px-3 py-2">
											{{$user->name}}
										</td>
										<td class="px-3 py-2">
											<x-select name="team[{{ $user->id }}][role]">
												<option value="">Select role...</option>

												@foreach ($projectRoles as $role)
													<option 
														value="{{ $role->value }}"
														@selected(
															old(
																"team.{$user->id}.role",
																$teamRoles->get($user->id)
															) === $role->value
														)
														>
														{{ $role->label() }}
													</option>
												@endforeach
											</x-select>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
				<div>
					<h3 class="font-bold text-lg">Client Users</h3>
					<p class="my-4 text-sm text-stone-500 dark:text-stone-400">Select client users who should have access to this project and their role.</p>
					<div class="overflow-hidden rounded-sm border border-stone-200 min-w-full border-1 border-stone-200 rounded-sm dark:divide-stone-800">
						<table class="border-collapse w-full divide-y">
							<thead class="bg-stone-50 dark:bg-stone-900">
								<th
									scope="col"
									class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-stone-500 dark:text-stone-400"
								>
									Client User
								</th>
								<th
									scope="col"
									class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-stone-500 dark:text-stone-400"
								>    
									Role on Project
								</th>
							</thead>
							<tbody id="clientUsers" class="divide-y divide-stone-200 bg-white dark:divide-stone-800 dark:bg-stone-950">
								@if (!isset($clientUsers))
									<tr>
										<td
											colspan="2"
											class="px-3 py-4 text-sm text-stone-500 dark:text-stone-400"
										>
											Select a client to view its users.
										</td>
									</tr>
								@else
									@foreach ($clientUsers as $user)
										<tr class="transition-colors hover:bg-stone-50 dark:hover:bg-stone-900">
											<td class="px-3 py-2">
												{{ $user->name }}
											</td>

											<td class="px-3 py-2">
												<x-select name="team[{{ $user->id }}][role]">
													<option value="">Select role...</option>

													@foreach ($projectRoles as $role)
														<option 
														value="{{ $role->value }}"
														@selected(
															old(
																"team.{$user->id}.role",
																$teamRoles->get($user->id)
															) === $role->value
														)
														>
															{{ $role->label() }}
														</option>
													@endforeach
												</x-select>
											</td>
										</tr>
									@endforeach
								@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="grid gap-6 md:grid-cols-2">
		<x-select
			name="status"
			label="Status"
			required
		>
			@foreach (\App\Enums\ProjectStatus::cases() as $status)
				<option
					value="{{ $status->value }}"
					@selected(old('status', $project->status->value ?? 'planning') === $status->value)
				>
					{{ $status->label() }}
				</option>
			@endforeach
		</x-select>

		<x-select
			name="priority"
			label="Priority"
			required
		>
			@foreach (\App\Enums\ProjectPriority::cases() as $priority)
				<option
					value="{{ $priority->value }}"
					@selected(old('priority', $project->priority->value ?? 'normal') === $priority->value)
				>
					{{ $priority->label() }}
				</option>
			@endforeach
		</x-select>
	</div>

	<div class="grid gap-6 md:grid-cols-2">
		<x-input
			name="start_date"
			label="Start Date"
			type="date"
			value="{{ old('start_date', isset($project?->start_date) ? $project->start_date->format('Y-m-d') : '') }}"
		/>

		<x-input
			name="due_date"
			label="Due Date"
			type="date"
			value="{{ old('due_date', isset($project?->due_date) ? $project->due_date->format('Y-m-d') : '') }}"
		/>
	</div>
</div>

<script>
	const projectRoleOptions = `
		<option value="">Select role...</option>

		@foreach ($projectRoles as $role)
			<option value="{{ $role->value }}">
				{{ $role->label() }}
			</option>
		@endforeach
	`

	const clientSelect = document.getElementById('client_id')
	const clientUsers = document.getElementById('clientUsers')

	clientSelect.addEventListener('change', async function () {
		const clientId = this.value

		if (!clientId) {
			clientUsers.innerHTML = `
				<tr>
					<td
						colspan="2"
						class="px-3 py-4 text-sm text-stone-500 dark:text-stone-400"
					>
						Select a client to view its users.
					</td>
				</tr>
			`

			return
		}

		clientUsers.innerHTML = `
			<tr>
				<td
					colspan="2"
					class="px-3 py-4 text-sm text-stone-500 dark:text-stone-400"
				>
					Loading users...
				</td>
			</tr>
		`

		const response = await fetch(
			`/clients/${clientId}/users/project-options`
		)

		if (!response.ok) {
			clientUsers.innerHTML = `
				<tr>
					<td
						colspan="2"
						class="px-3 py-4 text-sm text-red-600"
					>
						Unable to load client users.
					</td>
				</tr>
			`

			return
		}

		const users = await response.json()

		renderClientUsers(users)
	})

	function renderClientUsers(users) {
		if (!users.length) {
			clientUsers.innerHTML = `
				<tr>
					<td
						colspan="2"
						class="px-3 py-4 text-sm text-stone-500 dark:text-stone-400"
					>
						This client has no users.
					</td>
				</tr>
			`

			return
		}

		clientUsers.innerHTML = users.map(user => `
			<tr class="transition-colors hover:bg-stone-50 dark:hover:bg-stone-900">
				<td class="px-3 py-2">
					${user.name}
				</td>

				<td class="px-3 py-2">
					<select
						name="team[${user.id}][role]"
						class="w-full rounded-sm border border-stone-300 bg-white px-3 py-2 text-sm text-stone-900 dark:border-stone-700 dark:bg-stone-950 dark:text-stone-100"
					>
						${projectRoleOptions}
					</select>
				</td>
			</tr>
		`).join('')
	}
</script>