<?php

namespace App\Enums;

enum ProjectRole: string
{
	case ProjectManager = 'project_manager';

	case Developer = 'developer';
	case Designer = 'designer';
	case ContentWriter = 'content_writer';
	case SeoSpecialist = 'seo_specialist';

	case ClientApprover = 'client_approver';
	case ClientViewer = 'client_viewer';

    public function label(): String
    {
        return match ($this) {
        	self::ProjectManager => 'Project Manager',

            self::Developer => 'Developer',
            self::Designer => 'Designer',
            self::ContentWriter => 'Content Writer',
            self::SeoSpecialist => 'SEO Specialist',

            self::ClientApprover => 'Client Approver',
            self::ClientViewer => 'Client Viewer'
        };
    }
}