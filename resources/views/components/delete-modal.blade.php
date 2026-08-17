@props([
    'type',
	'name',
	'action',
    'modalName' => 'confirm-delete'
])

<x-modal name="{{ $modalName }}">
	<div class="space-y-4">
		<div class="p-6">
			<h2 class="text-lg font-semibold text-stone-900 dark:text-white">
				Delete {{ $type }}?
			</h2>

			<p class="mt-2 text-sm text-stone-600 dark:text-stone-400">
				Are you sure you want to delete
                <strong>{{ $name }}</strong>?
                This action cannot be undone.
			</p>
		</div>

        <div class="flex justify-end gap-2 border-t border-stone-200 bg-stone-50 px-6 py-4 dark:border-stone-800 dark:bg-stone-900/50">
            <form method="POST" action="{{ $action }}">
                @csrf
                @method('DELETE')

                <div class="flex justify-end gap-3">
                    <x-button
                        type="button"
                        variant="ghost"
                        x-on:click="$dispatch('close-modal', '{{ $modalName }}')"
                    >
                        Cancel
                    </x-button>

                    <x-button
                        type="submit"
                        variant="danger"
                    >
                        Delete
                    </x-button>
                </div>
            </form>
        </div>
	</div>
</x-modal>