<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}; ?>

<div>
	<div class="mb-8">
		<p class="mb-3 text-sm font-semibold uppercase tracking-[0.2em] text-indigo-600">
			Welcome back
		</p>

		<h1 class="text-3xl font-extrabold tracking-tight text-slate-950">
			Sign in to AgencyOS
		</h1>

		<p class="mt-3 text-sm leading-6 text-slate-500">
			Enter your account details to continue managing your agency.
		</p>
	</div>

	<x-auth-session-status
		class="mb-6 rounded-lg bg-indigo-50 px-4 py-3 text-sm text-indigo-700"
		:status="session('status')"
	/>

	<form
		wire:submit="login"
		class="space-y-6"
	>
		<flux:input
			wire:model="email"
			:label="__('Email address')"
			type="email"
			required
			autofocus
			autocomplete="email"
			placeholder="you@example.com"
		/>

		<div class="relative">
			<flux:input
				wire:model="password"
				:label="__('Password')"
				type="password"
				required
				autocomplete="current-password"
				placeholder="Enter your password"
				viewable
			/>

			@if (Route::has('password.request'))
				<flux:link
					:href="route('password.request')"
					class="absolute end-0 top-0 text-sm font-semibold text-indigo-600 hover:text-indigo-700"
					wire:navigate
				>
					{{ __('Forgot password?') }}
				</flux:link>
			@endif
		</div>

		<flux:checkbox
			wire:model="remember"
			:label="__('Remember me')"
		/>

		<flux:button
			variant="primary"
			type="submit"
			class="w-full bg-indigo-600 hover:bg-indigo-700"
			data-test="login-button"
		>
			<span class="flex items-center justify-center gap-2">
				{{ __('Sign in') }}

				<x-heroicon-o-arrow-right class="h-4 w-4" />
			</span>
		</flux:button>
	</form>

	@if (Route::has('register'))
		<p class="mt-8 text-center text-sm text-slate-500">
			Need an account?

			<flux:link
				:href="route('register')"
				class="font-semibold text-indigo-600 hover:text-indigo-700"
				wire:navigate
			>
				Create one
			</flux:link>
		</p>
	@endif

	<div class="mt-8 rounded-xl border border-slate-200 bg-slate-100/70 p-4">
		<div class="flex items-center justify-between gap-4">
			<div>
				<p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
					Demo account
				</p>

				<p class="mt-2 text-sm font-semibold text-slate-700">
					brian@agencyos.test
				</p>

				<p class="mt-1 text-sm text-slate-500">
					Password: password
				</p>
			</div>

			<x-heroicon-o-user-circle class="h-9 w-9 shrink-0 text-indigo-500" />
		</div>
	</div>
</div>