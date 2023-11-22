<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    public $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public $timestamps = false; // for table for GRC not for laravel base users table
    // public function User()
    // {
    //     return $this->hasMany(User::class,'user_id');
    // }
    public function permissions()
    {

        return DB::table('users')
            ->join('role_responsibilities', 'role_responsibilities.role_id', '=', 'users.role_id')
            ->join('permissions', 'permissions.id', '=', 'role_responsibilities.permission_id')
            ->select('permissions.key')
            ->where('users.id', '=', $this->id)
            ->where('role_responsibilities.role_id', '=', $this->role_id)
            ->get()->toArray();
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function hasPermission($name)
    {
        // $name = 'plan_mitigation.accept';
        $exist = auth()->user()->role->rolePermissions->where('key', $name)->first();
        // dd(auth()->user()->role->rolePermissions->pluck('key')->toArray());
        if ($exist)
            return true;
        return false;
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }


    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function managees()
    {
        return $this->hasMany(User::class, 'manager_id');
    }

    /**
     * Get the FrameworkControlTestComments for the user.
     */
    public function FrameworkControlTestComments()
    {
        return $this->hasMany(FrameworkControlTestComment::class);
    }

    /**
     * Get the created tasks by the user.
     */
    public function createdTasks()
    {
        return $this->hasMany(Task::class, 'created_by');
    }

    /**
     * Get the user's tasks.
     */
    public function tasks()
    {
        return $this->morphMany(Task::class, 'assignable');
    }

    /**
     * The teams that belong to the user.
     */
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'user_to_teams');
    }

    public function questionnaires(): BelongsToMany
    {
        return $this->belongsToMany(Questionnaire::class, 'contact_questionnaires', 'user_id', 'questionnaire_id');
    }

    public function questionnaireAnswers()
    {
        return $this->hasMany(ContactQuestionnaireAnswer::class, 'id', 'contact_id');
    }
}
