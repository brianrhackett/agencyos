<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>{{ $title ?? 'Error' }} | {{ config('app.name') }}</title>

		@vite(['resources/css/app.css', 'resources/js/app.js'])
	</head>

	<body class="h-full bg-stone-50 text-stone-900 dark:bg-stone-950 dark:text-stone-100">
		<div class="flex min-h-full flex-col">
			<header class="border-b border-stone-200 bg-white dark:border-stone-800 dark:bg-stone-900">
				<div class="flex h-20 items-center justify-center px-6">
					
					<x-app-logo class="h-7 w-auto" />
					
				</div>
			</header>

			<main class="flex flex-1 items-center justify-center px-6 py-16">
				{{ $slot }}
			</main>
		</div>
	</body>
</html>