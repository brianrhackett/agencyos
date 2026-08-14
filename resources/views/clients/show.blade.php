<x-layouts.app>
	<x-layouts.app.content
		:title="$client->name"
		description="Client details and project activity."
	>
		<div class="mb-6 flex items-center justify-between">
			<div>
				<span @class([
					'inline-flex rounded-full px-2.5 py-1 text-xs font-medium',
					'bg-emerald-100 text-emerald-700' => $client->is_active,
					'bg-stone-100 text-stone-600' => !$client->is_active,
				])>
					{{ $client->is_active ? 'Active' : 'Inactive' }}
				</span>
			</div>

			<x-button
				href="{{ route('clients.edit', $client) }}"
				variant="secondary"
			>
				Edit Client
			</x-button>
		</div>

		<div class="grid gap-6 lg:grid-cols-2">
			<x-card>
				<h2 class="mb-5 text-lg font-semibold">
					Contact Information
				</h2>

				<div class="space-y-4">
					<div>
						<p class="text-sm text-stone-500">Email</p>
						<p class="font-medium">
							{{ $client->email ?: '—' }}
						</p>
					</div>

					<div>
						<p class="text-sm text-stone-500">Phone</p>
						<p class="font-medium">
							{{ $client->phone ?: '—' }}
						</p>
					</div>

					<div>
						<p class="text-sm text-stone-500">Website</p>

						@if ($client->website)
							<a
								href="{{ $client->website }}"
								target="_blank"
								rel="noopener noreferrer"
								class="font-medium text-violet-600 hover:underline"
							>
								{{ $client->website }}
							</a>
						@else
							<p>—</p>
						@endif
					</div>
				</div>
			</x-card>

			<x-card>
				<h2 class="mb-5 text-lg font-semibold">
					Address
				</h2>

				<address class="not-italic leading-7 text-stone-700 dark:text-stone-300">
					@if ($client->address_line_one)
						<div>{{ $client->address_line_one }}</div>
					@endif

					@if ($client->address_line_two)
						<div>{{ $client->address_line_two }}</div>
					@endif

					@if ($client->city || $client->state || $client->postal_code)
						<div>
							{{ $client->city }}
							{{ $client->state }}
							{{ $client->postal_code }}
						</div>
					@endif

					@if ($client->country)
						<div>{{ $client->country }}</div>
					@endif
				</address>
			</x-card>
		</div>

		<x-card class="mt-6">
			<div class="flex items-center justify-between gap-4">
				<div>
					<h2 class="text-lg font-bold text-stone-900 dark:text-stone-100">
						Client Users
					</h2>

					<p class="mt-1 text-sm text-stone-500 dark:text-stone-400">
						Users with access to this client's account.
					</p>
				</div>

				<a
					href="{{ route('clients.users.create', $client) }}"
					class="text-sm font-semibold text-indigo-600 hover:text-indigo-700 dark:text-indigo-400"
				>
					Add User
				</a>
			</div>

			@if ($client->users->isEmpty())
				<p class="mt-6 text-sm text-stone-500 dark:text-stone-400">
					No client users have been added.
				</p>
			@else
				<div class="mt-6 divide-y divide-stone-200 dark:divide-stone-800">
					@foreach ($client->users as $member)
						<div class="flex items-center justify-between gap-4 py-4">
							<div>
								<div class="flex items-center gap-2">
									<p class="text-sm font-semibold text-stone-900 dark:text-stone-100">
										{{ $member->name }}
									</p>

									@if ($member->pivot->is_primary_contact)
										<x-badge variant="primary">
											Primary
										</x-badge>
									@endif
								</div>

								<p class="mt-1 text-sm text-stone-500 dark:text-stone-400">
									{{ $member->pivot->job_title ?? 'No job title' }}
									&middot;
									{{ $member->email }}
								</p>
							</div>
							<div x-data="{ modalOpen: false }">
								<x-dropdown-menu>
									<x-dropdown-menu.item
										href="{{ route('clients.users.edit', [$client, $member]) }}"
									>
										Edit
									</x-dropdown-menu.item>

									@if (auth()->user()->isAgencyUser())
										<x-dropdown-menu.item
											danger
											@click="modalOpen = true"
										>
											Delete
										</x-dropdown-menu.item>
									@endif
								</x-dropdown-menu>
								<x-modal show="modalOpen" maxWidth="md">
									<div class="space-y-4">
										<div class="px-6 py-4">
											<h2 class="text-lg font-bold text-stone-900 dark:text-stone-100">
												Delete Client User
											</h2>

											<p class="text-sm text-stone-600 dark:text-stone-400">
												Are you sure you want to delete {{ $member->name }}?
											</p>
										</div>
										<div class="flex justify-end gap-2 border-t border-stone-200 bg-stone-50 px-6 py-4 dark:border-stone-800 dark:bg-stone-900/50">
											<div class="flex justify-end gap-3">
												<x-button
													type="button"
													variant="secondary"
													@click="modalOpen = false"
												>
													Cancel
												</x-button>

												<form
													method="POST"
													action="{{ route('clients.users.destroy', [$client, $member]) }}"
												>
													@csrf
													@method('DELETE')

													<x-button
														type="submit"
														variant="danger"
													>
														Delete User
													</x-button>
												</form>
											</div>
										</div>
									</div>
								</x-modal>
							</div>
						</div>
					@endforeach
				</div>
			@endif
		</x-card>

		@if ($client->notes)
			<x-card class="mt-6">
				<h2 class="mb-4 text-lg font-semibold">
					Notes
				</h2>

				<p class="whitespace-pre-line text-stone-600 dark:text-stone-300">{{ $client->notes }}</p>
			</x-card>
		@endif
	</x-layouts.app.content>
</x-layouts.app>