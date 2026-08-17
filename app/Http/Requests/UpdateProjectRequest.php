<?php

namespace App\Http\Requests;

use App\Enums\ProjectRole;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class UpdateProjectRequest extends FormRequest
{
	public function authorize(): bool
	{
		return true;
	}

	public function rules(): array
	{
		return [
			'name' => ['required', 'string', 'max:255'],
			'description' => ['nullable', 'string'],
			'status' => ['required'],
			'priority' => ['required'],
			'budget' => ['nullable', 'numeric', 'min:0'],
			'start_date' => ['nullable', 'date'],
			'due_date' => ['nullable', 'date', 'after_or_equal:start_date'],

			'team' => ['nullable', 'array'],
			'team.*.role' => [
				'nullable',
				Rule::enum(ProjectRole::class),
			],
		];
	}

	public function after(): array
	{
		return [
			function (Validator $validator) {
				$project = $this->route('project');

				$team = collect($this->input('team', []))
					->filter(fn ($member) => !empty($member['role']));

				if ($team->isEmpty()) {
					$validator->errors()->add(
						'team',
						'At least one team member must be assigned.'
					);

					return;
				}

				$teamUserIds = $team
					->keys()
					->map(fn ($id) => (int) $id);

				$agencyUserIds = User::agency()
					->whereIn('id', $teamUserIds)
					->pluck('id');

				$clientUserIds = User::whereHas('clients', function ($query) use ($project) {
					$query->where('clients.id', $project->client_id);
				})
					->whereIn('id', $teamUserIds)
					->pluck('id');

				$allowedUserIds = $agencyUserIds
					->merge($clientUserIds)
					->unique();

				if ($teamUserIds->diff($allowedUserIds)->isNotEmpty()) {
					$validator->errors()->add(
						'team',
						'One or more selected users cannot be assigned to this project.'
					);
				}

				$leadIds = $team
					->filter(
						fn ($member) => $member['role'] === ProjectRole::Lead->value
					)
					->keys();

				if ($leadIds->count() !== 1) {
					$validator->errors()->add(
						'team',
						'Exactly one team member must be assigned as the project lead.'
					);
				}
			},
		];
	}
}