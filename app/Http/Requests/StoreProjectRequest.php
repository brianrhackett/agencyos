<?php

namespace App\Http\Requests;

use Illuminate\Validation\Validator;
use App\Enums\ProjectRole;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\User;

class StoreProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
			'client_id' => ['required', 'exists:clients,id'],
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
				$team = collect($this->input('team', []))
					->filter(fn ($member) => !empty($member['role']));

				if ($team->isEmpty()) {
					return;
				}

				$teamUserIds = $team
					->keys()
					->map(fn ($id) => (int) $id);

				$agencyUserIds = User::agency()
					->whereIn('id', $teamUserIds)
					->pluck('id');

				$clientUserIds = User::whereHas('clients', function ($query) {
					$query->where('clients.id', $this->input('client_id'));
				})
					->whereIn('id', $teamUserIds)
					->pluck('id');

				$allowedUserIds = $agencyUserIds
					->merge($clientUserIds)
					->unique();

				$invalidUserIds = $teamUserIds->diff($allowedUserIds);

				if ($invalidUserIds->isNotEmpty()) {
					$validator->errors()->add(
						'team',
						'One or more selected users cannot be assigned to this project.'
					);
				}

                $leads = $team->filter(
                    fn ($member) => $member['role'] === ProjectRole::Lead->value
                );

                if ($leads->count() !== 1) {
                    $validator->errors()->add(
                        'team',
                        'Exactly one team member must be assigned as the project lead.'
                    );
                }
			},
		];
    }
}
