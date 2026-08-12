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
		name="position"
		label="Position"
		value="{{ old('position', $user->position ?? '') }}"
	/>

	<x-input
		type="password"
		name="password"
		label="Password"
		:required="!isset($user)"
	/>

	<x-input
		type="password"
		name="password_confirmation"
		label="Confirm Password"
		:required="!isset($user)"
	/>
</div>