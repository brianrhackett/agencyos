<?php

namespace App\Enums;

enum Permission: string
{
	// Clients
	case ClientsView = 'clients.view';
	case ClientsCreate = 'clients.create';
	case ClientsUpdate = 'clients.update';
	case ClientsDelete = 'clients.delete';
    
	case ClientUsersManage = 'client_users.manage';

	// Projects
	case ProjectsView = 'projects.view';
	case ProjectsCreate = 'projects.create';
	case ProjectsUpdate = 'projects.update';
	case ProjectsDelete = 'projects.delete';

	// Milestones
	case MilestonesView = 'milestones.view';
	case MilestonesCreate = 'milestones.create';
	case MilestonesUpdate = 'milestones.update';
	case MilestonesDelete = 'milestones.delete';

	// Tasks
	case TasksView = 'tasks.view';
	case TasksCreate = 'tasks.create';
	case TasksUpdate = 'tasks.update';
	case TasksDelete = 'tasks.delete';
	case TasksAssign = 'tasks.assign';
	case TasksApprove = 'tasks.approve';

	// Files
	case FilesView = 'files.view';
	case FilesUpload = 'files.upload';
	case FilesDelete = 'files.delete';

	// Team
	case TeamView = 'team.view';
	case TeamManage = 'team.manage';
}