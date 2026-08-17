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

		if (auth()->user()->isClientUser()) {
			$this->redirect(
				route('projects.index', absolute: false),
				navigate: true
			);

			return;
		}

		$this->redirectIntended(
			default: route('dashboard', absolute: false),
			navigate: true
		);
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
	<div>
		<p class="text-sm font-bold uppercase tracking-[0.18em] text-indigo-600 dark:text-indigo-300">
			Welcome back
		</p>

		<h1 class="mt-3 text-3xl font-extrabold tracking-tight text-stone-950 dark:text-stone-50">
			Sign in to your account
		</h1>

		<p class="mt-3 text-sm leading-6 text-stone-500 dark:text-stone-400">
			Enter your account details to continue to AgencyOS.
		</p>
	</div>

	<x-auth-session-status
		class="mt-6 rounded-sm border border-indigo-200 bg-indigo-50 px-4 py-3 text-sm text-indigo-700"
		:status="session('status')"
	/>

	<form
		wire:submit="login"
		class="mt-8 space-y-6"
	>
		<x-input
			label="Email address"
			name="email"
			type="email"
			placeholder="you@example.com"
			wire:model="email"
			autocomplete="email"
			autofocus
			required
		/>

		<div>
			<div class="mb-2 flex items-center justify-between">
				<label
					for="password"
					class="text-sm font-semibold text-stone-700"
				>
					Password
				</label>

				@if (Route::has('password.request'))
					<a
						href="{{ route('password.request') }}"
						class="text-sm font-semibold text-indigo-600 transition hover:text-indigo-700 dark:text-indigo-300 dark:hover:text-indigo-200"
						wire:navigate
					>
						Forgot password?
					</a>
				@endif
			</div>

			<x-input
				id="password"
				name="password"
				type="password"
				wire:model="password"
				autocomplete="current-password"
				required
			/>

			<x-form.error name="password" />
		</div>

		<label class="flex cursor-pointer items-center gap-3">
			<input
				type="checkbox"
				wire:model="remember"
				class="h-4 w-4 rounded border-stone-300 text-indigo-600 focus:ring-indigo-500 dark:tex-indigo-300 dark:focus:ring-indigo-400"
			>

			<span class="text-sm text-stone-600 dark:text-stone-300">
				Remember me
			</span>
		</label>

		<x-button
			type="submit"
			class="w-full"
			wire:loading.attr="disabled"
			wire:target="login"
		>
			<span wire:loading.remove wire:target="login">
				Sign in
			</span>

			<span wire:loading wire:target="login">
				Signing in...
			</span>

			<x-heroicon-o-arrow-right
				class="h-4 w-4"
				wire:loading.remove
				wire:target="login"
			/>
		</x-button>
	</form>

	@if (Route::has('register'))
		<p class="mt-8 text-center text-sm text-stone-500 dark:text-stone-400">
			Don&rsquo;t have an account?

			<a
				href="{{ route('register') }}"
				class="font-semibold text-indigo-600 transition hover:text-indigo-700 dark:text-indigo-300 dark:hover:text-indigo-400"
				wire:navigate
			>
				Create an account
			</a>
		</p>
	@endif

	<div class="mt-8 border-t border-stone-200 pt-6 dark:border-stone-700">
		<div class="rounded-sm bg-stone-50 px-4 py-4 dark:bg-stone-900">
			<div class="flex items-start gap-3">
				<div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-sm bg-indigo-100">
					<x-heroicon-o-user class="h-5 w-5 text-indigo-600" />
				</div>

				<div>
					<p class="text-xs font-bold uppercase tracking-wide text-stone-500 dark:text-stone-400">
						Demo account
					</p>

					<p class="mt-2 text-sm font-semibold text-stone-800 dark:text-stone-100">
						brian@agencyos.test
					</p>

					<p class="mt-1 text-sm text-stone-500 dark:text-stone-400">
						Password: password
					</p>
				</div>
			</div>
		</div>
	</div>
</div>