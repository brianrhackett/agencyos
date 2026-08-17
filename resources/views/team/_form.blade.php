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
			value="{{ old('job_title', $jobTitle ?? '') }}"
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
</div>