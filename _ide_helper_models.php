<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Admin
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $is_super_admin
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Department[] $departments
 * @property-read int|null $departments_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\AdminFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin query()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereIsSuperAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereUpdatedAt($value)
 */
	class Admin extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AdminDepartment
 *
 * @property int $admin_id
 * @property int $department_id
 * @method static \Illuminate\Database\Eloquent\Builder|AdminDepartment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminDepartment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminDepartment query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminDepartment whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminDepartment whereDepartmentId($value)
 */
	class AdminDepartment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Department
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Election[] $elections
 * @property-read int|null $elections_count
 * @method static \Database\Factories\DepartmentFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Department newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Department newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Department query()
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereUpdatedAt($value)
 */
	class Department extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DepartmentElection
 *
 * @property int $department_id
 * @property int $election_id
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentElection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentElection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentElection query()
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentElection whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentElection whereElectionId($value)
 */
	class DepartmentElection extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Election
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 * @property \Illuminate\Support\Carbon $start_at
 * @property \Illuminate\Support\Carbon $end_at
 * @property int|null $election_type_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Department[] $department
 * @property-read int|null $department_count
 * @property-read \App\Models\ElectionType|null $electionType
 * @method static \Database\Factories\ElectionFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Election newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Election newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Election query()
 * @method static \Illuminate\Database\Eloquent\Builder|Election whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Election whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Election whereElectionTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Election whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Election whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Election whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Election whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Election whereUpdatedAt($value)
 */
	class Election extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ElectionType
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Election[] $elections
 * @property-read int|null $elections_count
 * @method static \Illuminate\Database\Eloquent\Builder|ElectionType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ElectionType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ElectionType query()
 * @method static \Illuminate\Database\Eloquent\Builder|ElectionType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ElectionType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ElectionType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ElectionType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ElectionType whereUpdatedAt($value)
 */
	class ElectionType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Program
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Program newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Program newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Program query()
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereUpdatedAt($value)
 */
	class Program extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $department_id
 * @property int $program_id
 * @property int $year_level_id
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProgramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereYearLevelId($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\YearLevel
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|YearLevel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|YearLevel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|YearLevel query()
 * @method static \Illuminate\Database\Eloquent\Builder|YearLevel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|YearLevel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|YearLevel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|YearLevel whereUpdatedAt($value)
 */
	class YearLevel extends \Eloquent {}
}

