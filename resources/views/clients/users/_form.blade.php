<div class="space-y-6">
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

	<x-input
		name="job_title"
		label="Job Title"
		value="{{ old('job_title', $user->pivot->job_title ?? '') }}"
	/>

	<x-input
		name="role"
		label="Role"
		value="{{ old('role', $user->pivot->role ?? '') }}"
	/>

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

	<x-input
		type="password"
		name="password"
		label="Password"
		:required="!isset($user)"
	/>

	@if (isset($user))
        <p class="text-xs text-stone-500 dark:text-stone-400">
            Leave blank to keep the current password.
        </p>
    @endif

	<x-input
		type="password"
		name="password_confirmation"
		label="Confirm Password"
		:required="!isset($user)"
	/>
</div>