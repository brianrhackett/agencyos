<?php

namespace App\Models;

use App\Enums\Permission;
use App\Enums\AgencyRole;
use Illuminate\Support\Facades\DB;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable // implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'position',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * IMPORTANT FUNCTION
     * checks if user has permission to perform an action
     */
    public function hasPermission(Permission $permission): bool
    {
        if ($this->agencyUser) {
            return DB::table('agency_role_permissions')
                ->where('role', $this->agencyUser->role->value)
                ->where('permission', $permission->value)
                ->where('allowed', true)
                ->exists();
        }

        $clientMembership = $this->clients->first()?->pivot;

        if ($clientMembership) {
            return DB::table('client_role_permissions')
                ->where('role', $clientMembership->role)
                ->where('permission', $permission->value)
                ->where('allowed', true)
                ->exists();
        }

        return false;
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    public function clients(): BelongsToMany
    {
        return $this->belongsToMany(Client::class)
            ->withPivot([
                'role',
                'job_title',
                'is_primary_contact',
            ])
            ->withTimestamps();
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class)
            ->withPivot([
                'role',
                'can_view_financials',
            ])
            ->withTimestamps();
    }

    public function clientMemberships()
    {
        return $this->hasMany(ClientUser::class);
    }

    public function assignedTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }

    public function scopeAgency($query)
    {
        return $query->whereDoesntHave('clients');
    }

    public function isAgencyUser(): bool
    {
        return !$this->clients()->exists();
    }

    public function isClientUser(): bool
    {
        return $this->clients()->exists();
    }

    public function currentClient(): ?Client
    {
        return $this->clients()->first();
    }

    public function agencyUser()
    {
        return $this->hasOne(AgencyUser::class);
    }

    public function belongsToClient(int $clientId): bool
    {
        return $this->clients()
            ->where('clients.id', $clientId)
            ->exists();
    }

    public function canViewAllProjects(): bool
    {
        return in_array($this->agencyUser?->role, [
            AgencyRole::SuperAdmin,
            AgencyRole::Administrator,
            AgencyRole::Manager,
        ], true);
    }
}
