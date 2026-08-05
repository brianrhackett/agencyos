<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Comment;
use App\Models\Milestone;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AgencyOsSeeder extends Seeder
{
	public function run(): void
	{
		$admin = User::query()->create([
			'name' => 'Brian Hackett',
			'email' => 'brian@agencyos.test',
			'password' => Hash::make('password'),
			'email_verified_at' => now(),
		]);

		$projectManager = User::query()->create([
			'name' => 'Maya Rodriguez',
			'email' => 'maya@agencyos.test',
			'password' => Hash::make('password'),
			'email_verified_at' => now(),
		]);

		$designer = User::query()->create([
			'name' => 'Ethan Brooks',
			'email' => 'ethan@agencyos.test',
			'password' => Hash::make('password'),
			'email_verified_at' => now(),
		]);

		$acmeContact = User::query()->create([
			'name' => 'Sarah Mitchell',
			'email' => 'sarah@acme.test',
			'password' => Hash::make('password'),
			'email_verified_at' => now(),
		]);

		$acmeReviewer = User::query()->create([
			'name' => 'Daniel Kim',
			'email' => 'daniel@acme.test',
			'password' => Hash::make('password'),
			'email_verified_at' => now(),
		]);

		$northstarContact = User::query()->create([
			'name' => 'Olivia Bennett',
			'email' => 'olivia@northstar.test',
			'password' => Hash::make('password'),
			'email_verified_at' => now(),
		]);

		$acme = Client::query()->create([
			'name' => 'Acme Outdoor Supply',
			'website' => 'https://acme-outdoor.test',
			'email' => 'hello@acme-outdoor.test',
			'phone' => '412-555-0148',
			'city' => 'Pittsburgh',
			'state' => 'Pennsylvania',
			'postal_code' => '15222',
			'notes' => 'Growing outdoor retailer preparing for a national expansion.',
		]);

		$northstar = Client::query()->create([
			'name' => 'Northstar Financial Group',
			'website' => 'https://northstar-financial.test',
			'email' => 'contact@northstar-financial.test',
			'phone' => '614-555-0194',
			'city' => 'Columbus',
			'state' => 'Ohio',
			'postal_code' => '43215',
			'notes' => 'Regional financial advisory company.',
		]);

		$acme->users()->attach([
			$acmeContact->id => [
				'role' => 'administrator',
				'job_title' => 'Marketing Director',
				'is_primary_contact' => true,
			],
			$acmeReviewer->id => [
				'role' => 'approver',
				'job_title' => 'Director of E-commerce',
				'is_primary_contact' => false,
			],
		]);

		$northstar->users()->attach($northstarContact->id, [
			'role' => 'administrator',
			'job_title' => 'Communications Manager',
			'is_primary_contact' => true,
		]);

		$websiteRedesign = Project::query()->create([
			'client_id' => $acme->id,
			'project_manager_id' => $projectManager->id,
			'name' => 'E-commerce Website Redesign',
			'slug' => Str::slug('E-commerce Website Redesign'),
			'description' => 'Redesign and rebuild the client’s primary e-commerce website.',
			'status' => 'active',
			'priority' => 'high',
			'budget' => 48000,
			'start_date' => now()->subWeeks(2)->toDateString(),
			'due_date' => now()->addMonths(4)->toDateString(),
		]);

		$brandRefresh = Project::query()->create([
			'client_id' => $northstar->id,
			'project_manager_id' => $admin->id,
			'name' => 'Digital Brand Refresh',
			'slug' => Str::slug('Digital Brand Refresh'),
			'description' => 'Refresh the visual identity and create a new marketing website.',
			'status' => 'planning',
			'priority' => 'normal',
			'budget' => 27500,
			'start_date' => now()->addWeek()->toDateString(),
			'due_date' => now()->addMonths(3)->toDateString(),
		]);

		$websiteRedesign->users()->attach([
			$projectManager->id => [
				'role' => 'project_manager',
				'can_view_financials' => true,
			],
			$admin->id => [
				'role' => 'developer',
				'can_view_financials' => true,
			],
			$designer->id => [
				'role' => 'designer',
				'can_view_financials' => false,
			],
			$acmeContact->id => [
				'role' => 'client_viewer',
				'can_view_financials' => false,
			],
			$acmeReviewer->id => [
				'role' => 'client_approver',
				'can_view_financials' => false,
			],
		]);

		$brandRefresh->users()->attach([
			$admin->id => [
				'role' => 'project_manager',
				'can_view_financials' => true,
			],
			$designer->id => [
				'role' => 'designer',
				'can_view_financials' => false,
			],
			$northstarContact->id => [
				'role' => 'client_approver',
				'can_view_financials' => false,
			],
		]);

		$discovery = Milestone::query()->create([
			'project_id' => $websiteRedesign->id,
			'name' => 'Discovery',
			'description' => 'Requirements gathering, stakeholder interviews, and content audit.',
			'status' => 'completed',
			'sort_order' => 1,
			'start_date' => now()->subWeeks(2)->toDateString(),
			'due_date' => now()->subWeek()->toDateString(),
			'completed_at' => now()->subDays(6),
		]);

		$design = Milestone::query()->create([
			'project_id' => $websiteRedesign->id,
			'name' => 'UX and Visual Design',
			'description' => 'Wireframes, design system, and page mockups.',
			'status' => 'in_progress',
			'sort_order' => 2,
			'start_date' => now()->subDays(5)->toDateString(),
			'due_date' => now()->addWeeks(3)->toDateString(),
		]);

		$development = Milestone::query()->create([
			'project_id' => $websiteRedesign->id,
			'name' => 'Development',
			'description' => 'Frontend and backend implementation.',
			'status' => 'not_started',
			'sort_order' => 3,
			'start_date' => now()->addWeeks(3)->toDateString(),
			'due_date' => now()->addMonths(3)->toDateString(),
		]);

		$kickoffTask = Task::query()->create([
			'project_id' => $websiteRedesign->id,
			'milestone_id' => $discovery->id,
			'assigned_to' => $projectManager->id,
			'created_by' => $admin->id,
			'title' => 'Conduct stakeholder kickoff meeting',
			'description' => 'Meet with the client team and document the primary business objectives.',
			'status' => 'completed',
			'priority' => 'high',
			'estimated_hours' => 2,
			'actual_hours' => 2.5,
			'due_date' => now()->subDays(10)->toDateString(),
			'completed_at' => now()->subDays(10),
		]);

		$wireframeTask = Task::query()->create([
			'project_id' => $websiteRedesign->id,
			'milestone_id' => $design->id,
			'assigned_to' => $designer->id,
			'created_by' => $projectManager->id,
			'title' => 'Create homepage wireframes',
			'description' => 'Create desktop and mobile wireframes for the new homepage.',
			'status' => 'in_review',
			'priority' => 'high',
			'estimated_hours' => 12,
			'actual_hours' => 10.5,
			'due_date' => now()->addDays(2)->toDateString(),
		]);

		Task::query()->create([
			'project_id' => $websiteRedesign->id,
			'milestone_id' => $development->id,
			'assigned_to' => $admin->id,
			'created_by' => $projectManager->id,
			'title' => 'Set up project development environment',
			'description' => 'Prepare the local, staging, and deployment environments.',
			'status' => 'to_do',
			'priority' => 'normal',
			'estimated_hours' => 4,
			'due_date' => now()->addWeeks(3)->toDateString(),
		]);

		Task::query()->create([
			'project_id' => $websiteRedesign->id,
			'milestone_id' => null,
			'assigned_to' => $projectManager->id,
			'created_by' => $admin->id,
			'title' => 'Collect hosting credentials',
			'description' => 'Obtain the current hosting and DNS credentials from the client.',
			'status' => 'blocked',
			'priority' => 'normal',
			'due_date' => now()->addDays(4)->toDateString(),
		]);

		Comment::query()->create([
			'task_id' => $kickoffTask->id,
			'user_id' => $projectManager->id,
			'body' => 'Kickoff completed. Meeting notes have been added to the project documentation.',
			'is_internal' => false,
		]);

		Comment::query()->create([
			'task_id' => $wireframeTask->id,
			'user_id' => $designer->id,
			'body' => 'The first wireframe draft is ready for internal review.',
			'is_internal' => true,
		]);

		Comment::query()->create([
			'task_id' => $wireframeTask->id,
			'user_id' => $acmeReviewer->id,
			'body' => 'The layout looks good. Could we give featured categories more prominence?',
			'is_internal' => false,
		]);
	}
}