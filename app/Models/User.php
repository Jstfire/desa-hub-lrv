<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Traits\HasRoleHelpers;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $two_factor_confirmed_at
 * @property string|null $remember_token
 * @property int|null $current_team_id
 * @property string|null $profile_photo_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @method bool hasRole(string|array|\Spatie\Permission\Contracts\Role $roles)
 * @method bool hasAnyRole(string|array|\Spatie\Permission\Contracts\Role $roles)
 * @method bool hasAllRoles(string|array|\Spatie\Permission\Contracts\Role $roles)
 * @method bool hasPermissionTo(string|\Spatie\Permission\Contracts\Permission $permission, string|null $guardName = null)
 * @method bool hasAnyPermission(string|array|\Spatie\Permission\Contracts\Permission $permissions)
 * @method bool hasAllPermissions(string|array|\Spatie\Permission\Contracts\Permission $permissions)
 */
/**
 * User model with authentication, permissions and team capabilities.
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property int|null $current_team_id
 * @property string|null $profile_photo_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $two_factor_confirmed_at
 * @property-read \App\Models\Team|null $currentTeam
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Team> $ownedTeams
 * @property-read int|null $owned_teams_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read string $profile_photo_url
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \App\Models\Membership|null $membership
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Team> $teams
 * @property-read int|null $teams_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCurrentTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereProfilePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, $guard = null)
 * @mixin \Eloquent
 */
class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens;
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use HasRoles;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
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
     * Determine if the user can access the Filament panel.
     *
     * @param \Filament\Panel $panel
     * @return bool
     */
    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'superadmin') {
            // Allow access for superadmin, admin_desa, and operator_desa roles
            return $this->hasRole(['superadmin', 'admin_desa', 'operator_desa']);
        }
        return true;
    }

    /**
     * Override the default hasRole method to use our PostgreSQL-compatible version.
     */
    public function hasRole($roles, $guard = null): bool
    {
        if (config('database.default') === 'pgsql') {
            // For PostgreSQL, use a more reliable method that avoids the problematic query
            if (is_string($roles)) {
                return $this->roles->contains('name', $roles);
            }

            if (is_array($roles)) {
                $roleNames = $this->roles->pluck('name')->toArray();
                return !empty(array_intersect($roles, $roleNames));
            }

            if ($roles instanceof \Spatie\Permission\Contracts\Role) {
                return $this->roles->contains('id', $roles->id);
            }

            return false;
        }

        // Call the parent hasRole method from the HasRoles trait for other database drivers
        return parent::hasRole($roles, $guard);
    }

    /**
     * Override hasAnyRole for PostgreSQL compatibility
     */
    public function hasAnyRole($roles): bool
    {
        if (config('database.default') === 'pgsql') {
            return $this->hasRole($roles);
        }

        return parent::hasAnyRole($roles);
    }

    /**
     * Override hasAllRoles for PostgreSQL compatibility
     */
    public function hasAllRoles($roles, $guard = null): bool
    {
        if (config('database.default') === 'pgsql') {
            if (is_string($roles)) {
                return $this->hasRole($roles, $guard);
            }

            if (is_array($roles)) {
                $roleNames = $this->roles->pluck('name')->toArray();
                return empty(array_diff($roles, $roleNames));
            }

            return false;
        }

        return parent::hasAllRoles($roles, $guard);
    }
}
