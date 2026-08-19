import Sortable from 'sortablejs'

document.querySelectorAll('.task-column').forEach((column) => {
	new Sortable(column, {
		group: 'tasks',
		animation: 150,
		ghostClass: 'opacity-50',
        draggable: '.task-card',

		async onEnd(event) {
			const taskId = event.item.dataset.taskId
			const status = event.to.dataset.status

			try {
				const response = await fetch(`/tasks/${taskId}/status`, {
					method: 'PATCH',
					headers: {
						'Content-Type': 'application/json',
						'Accept': 'application/json',
						'X-CSRF-TOKEN': document
							.querySelector('meta[name="csrf-token"]')
							.getAttribute('content')
					},
					body: JSON.stringify({
						status
					})
				})

				if (!response.ok) {
					throw new Error('Unable to update task.')
				}

                updateColumnCount(event.from)
		        if (event.to !== event.from) {
                    updateColumnCount(event.to)
                }
			} catch (error) {
				console.error(error)

				// Put the card back if the request fails.
				event.from.insertBefore(
					event.item,
					event.from.children[event.oldIndex] ?? null
				)
			}
		}
	})
})

function updateColumnCount(column) {
	const count = column.querySelectorAll('.task-card').length

	const card = column.closest('[data-board-column]')
	const countElement = card?.querySelector('.task-count')

	if (countElement) {
		countElement.textContent = count
	}
}