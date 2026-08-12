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