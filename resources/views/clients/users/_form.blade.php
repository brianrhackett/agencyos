<div class="space-y-6">
	<div class="grid gap-6 grid-cols-1 md:grid-cols-2">
		<x-input
			name="name"
			label="Name"
			value="{{ old('name', $user->name ?? '') }}"
			required
		/>

		<x-input
			type="email"
			name="email"
			label="Email"
			value="{{ old('email', $user->email ?? '') }}"
			required
		/>
	</div>

	<div class="grid gap-6 grid-cols-1 md:grid-cols-2">
		<x-input
			name="job_title"
			label="Job Title"
			value="{{ old('job_title', $user->pivot->job_title ?? '') }}"
		/>

		<x-select
			name="role"
			label="User Role"
		>
			<option value="">Select role...</option>

			@foreach ($roles as $userRole)
				<option 
					value="{{ $userRole->value }}"
					@selected(
						old("role",$role) == $userRole->value
					)
				>
					{{ $userRole->label() }}
				</option>
			@endforeach
		</x-select>
	</div>

	<div class="grid gap-6 grid-cols-1 md:grid-cols-2">
		<label class="flex items-center gap-3">
			<input
				type="checkbox"
				name="is_primary_contact"
				value="1"
				@checked(old(
					'is_primary_contact',
					$user->pivot->is_primary_contact ?? false
				))
			>

			<span class="text-sm font-medium text-stone-700 dark:text-stone-300">
				Primary Contact
			</span>
		</label>
	</div>

</div>