# AgencyOS

AgencyOS is a client and project management portal built for digital agencies. It provides a central workspace for managing clients, projects, milestones, tasks, team members, files, and client communication while providing client users with secure, limited access to their organization's work.

The project was built as a Laravel-focused full-stack application using server-rendered Blade templates and a PostgreSQL database.

## Features

### Client Management

* Create and manage agency clients
* Assign client users and primary contacts
* Store client contact and organizational information
* Separate agency and client user access
* Client-specific project visibility

### Project Management

* Create and manage projects for individual clients
* Assign agency and client users to project teams
* Project roles including Lead, Member, and Viewer
* Automatic project manager assignment based on the project's Lead
* Project status and priority tracking
* Budgets, start dates, due dates, and completion tracking
* Project overview and Kanban-style board views

### Task Management

* Create tasks directly or within a project or milestone
* Assign tasks to project team members
* Track task status, priority, estimated hours, and actual hours
* Due date and completion tracking
* Global task list and Kanban board
* Project-specific task boards
* Task comments
* File attachments

### Milestones

* Organize project work into optional milestones
* Track milestone status and due dates
* Associate tasks with milestones
* Display upcoming milestones throughout the application

### Team Management

* Manage agency and client users
* Agency and client-specific roles and permissions
* Job title management
* Project team assignments
* Primary client contacts
* Financial visibility controls
* Secure password reset workflow

### Files

* Upload files directly to tasks
* Browse files across projects
* Filter files by project and type
* File type and storage summaries
* Recent upload tracking
* Secure file download and deletion

### Calendar

* Monthly calendar view
* Project, milestone, and task deadlines
* Links directly to related records
* Overdue item indicators

### Dashboard

Agency users receive an overview of current agency activity, including:

* Active projects
* Client totals
* Tasks due today
* Tasks awaiting review
* Projects requiring attention
* Upcoming milestones
* Recent activity

### Search & Filtering

Search and filtering are available throughout the application for quickly locating:

* Clients
* Projects
* Tasks
* Milestones
* Team members
* Files

A global search provides access to records across the application.

## Authorization

AgencyOS uses Laravel policies and a role/permission system to control application access.

Users are divided into two primary groups:

**Agency Users**
Internal agency team members with permissions determined by their agency role.

**Client Users**
External users associated with a specific client. Client users can only access data belonging to their own organization and are restricted according to their client role.

Authorization is enforced server-side through policies and scoped queries rather than relying solely on UI visibility.

Project team assignments provide additional project context through Lead, Member, and Viewer roles.

## Authentication

AgencyOS includes:

* Login/logout
* Password reset
* Secure password setup for newly created users
* Profile management
* Password reset links generated through Laravel's password broker

Administrators do not set or edit user passwords directly.

## Tech Stack

* **PHP**
* **Laravel**
* **Blade**
* **Livewire / Volt**
* **Tailwind CSS**
* **PostgreSQL**
* **Vite**
* **Heroicons**

The application intentionally avoids a separate JavaScript SPA framework, keeping the primary application architecture centered around Laravel and server-rendered Blade templates.

JavaScript is used selectively for interactive functionality such as dynamically loading client users when creating projects.

## Database Structure

Core application entities include:

* Users
* Agency Users
* Clients
* Client Users
* Projects
* Project Users
* Milestones
* Tasks
* Comments
* Files
* Activities

Relationships are used extensively to model client membership, project teams, task assignments, file ownership, and project organization.

## Local Development

### Requirements

* PHP
* Composer
* Node.js / npm
* PostgreSQL

### Installation

Clone the repository:

```bash
git clone https://github.com/brianrhackett/agencyos
cd agencyos
```

Install PHP dependencies:

```bash
composer install
```

Install frontend dependencies:

```bash
npm install
```

Create the environment file:

```bash
cp .env.example .env
```

Generate an application key:

```bash
php artisan key:generate
```

Configure the PostgreSQL connection in `.env`:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=agencyos
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Run the migrations:

```bash
php artisan migrate
```

If demo seeders are available:

```bash
php artisan db:seed
```

Build frontend assets:

```bash
npm run build
```

Or run Vite during development:

```bash
npm run dev
```

Start Laravel:

```bash
php artisan serve
```

The application will normally be available at:

```text
http://127.0.0.1:8000
```

## Local Email Testing

AgencyOS uses Laravel's mail system for password reset links.

For local development, emails can be written to the Laravel log instead of being delivered:

```env
MAIL_MAILER=log
```

Password reset emails can then be viewed in:

```text
storage/logs/laravel.log
```

This allows the full password reset workflow to be tested without configuring an SMTP provider.

## Design

AgencyOS uses a custom responsive interface built with Tailwind CSS.

The design system includes:

* Indigo branding
* Stone neutral palette
* Plus Jakarta Sans typography
* Light and dark modes
* Reusable Blade form and UI components
* Responsive tables and navigation
* Minimal use of shadows
* Compact border radii
* Consistent status and priority badges

## Project Goals

AgencyOS was created to demonstrate a production-style Laravel application beyond basic CRUD functionality.

The project focuses on:

* Relational database design
* Role-based authorization
* Laravel policies
* Eloquent relationships
* Pivot models and enum casting
* Form Requests and validation
* File handling
* Search and filtering
* Context-aware interfaces
* Reusable Blade components
* Responsive application design
* Multi-tenant-style data isolation

## Status

AgencyOS is under final development and refinement.

Core client, project, task, milestone, team, calendar, file management, authorization, search, and Kanban functionality are implemented. Current work is focused primarily on final UI polish, authorization testing, demo data, and deployment.

## License

This project was created as a portfolio project. All rights reserved.
