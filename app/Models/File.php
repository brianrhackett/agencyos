<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\User;

class File extends Model
{
	use SoftDeletes;

	protected $fillable = [
        'task_id',
        'uploaded_by',
        'name',
        'original_name',
        'path',
        'mime_type',
        'size',
        'is_client_visible',
	];

	public function task(): BelongsTo
	{
		return $this->belongsTo(Task::class);
	}

	public function uploader(): BelongsTo
	{
		return $this->belongsTo(User::class, 'uploaded_by');
	}

    public function typeLabel(): string
    {
        return match (true) {
            $this->mime_type === 'application/pdf' => 'PDF',
            str_starts_with($this->mime_type, 'image/') => 'Image',
            in_array($this->mime_type, [
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'text/csv',
            ]) => 'Spreadsheet',
            in_array($this->mime_type, [
                'application/zip',
                'application/x-rar-compressed',
                'application/x-7z-compressed',
                'application/gzip',
            ]) => 'Archive',
            default => 'Document',
        };
    }

    public function icon(): string
    {
        return match ($this->typeLabel()) {
            'PDF' => 'document-text',
            'Image' => 'photo',
            'Spreadsheet' => 'table-cells',
            'Archive' => 'archive-box',
            default => 'document',
        };
    }

    public function iconClasses(): string
    {
        return match ($this->typeLabel()) {
            'PDF' => 'bg-red-100 text-red-700 dark:bg-red-950 dark:text-red-300',
            'Image' => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300',
            'Spreadsheet' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300',
            'Archive' => 'bg-amber-100 text-amber-700 dark:bg-amber-950 dark:text-amber-300',
            default => 'bg-sky-100 text-sky-700 dark:bg-sky-950 dark:text-sky-300',
        };
    }

    public function scopeVisibleTo($query, User $user)
    {
        // SuperAdmin / agency users with global project visibility.
        if ($user->canViewAllProjects()) {
            return $query;
        }
        
        return $query->whereHas('task', function ($query) use ($user) {
                $query->visibleTo($user);
            });
    }
}