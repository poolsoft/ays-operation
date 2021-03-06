<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @method static find($primaryKey)
 * @method static select(array $array)
 * @method static where(string $column, string $data)
 * @method static whereBetween($column, array $array)
 * @method static whereIn(string $column, string $operator, array $array)
 * @method static whereNotIn($column, array $excepts)
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function roles()
    {
        if (is_null($this->top)) {
            return Role::where('user_id', $this->id)->get();
        }

        $topUser = User::find($this->top);
        while (!is_null($topUser->top)) {
            $topUser = User::find($topUser->top);
        }

        return Role::where('user_id', $topUser->id)->get();
    }

    public function authority($permission): bool
    {
        return $this->role->permissions()->where('permission_id', $permission)->exists() ? true : false;
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class);
    }

    public function customPercents()
    {
        return $this->hasMany(CustomPercent::class);
    }

    public function notes()
    {
        return $this->morphMany(Note::class, 'creator');
    }

    public function files()
    {
        return $this->morphMany(File::class, 'uploader');
    }

    public function timesheets()
    {
        return $this->morphMany(Timesheet::class, 'starter');
    }

    public function tickets()
    {
        return $this->morphMany(Ticket::class, 'creator');
    }

    public function ticketMessages()
    {
        return $this->morphMany(TicketMessage::class, 'creator');
    }

    public function messages()
    {
        return $this->morphMany(ChatMessage::class, 'sender');
    }

    public function meetings()
    {
        return $this->morphToMany(Meeting::class, 'relation', 'meeting_relations');
    }

    public function calendarNotes()
    {
        return $this->morphMany(CalendarNote::class, 'creator');
    }

    public function calendarInformations()
    {
        return $this->morphMany(CalendarInformation::class, 'creator');
    }

    public function createdMeetings()
    {
        return $this->hasMany(Meeting::class, 'creator_id', 'id');
    }

    public function calendarReminders()
    {
        return $this->morphMany(CalendarReminder::class, 'relation');
    }

    public function managementDepartments()
    {
        return $this->belongsToMany(ManagementDepartment::class);
    }

    public function recruitingActivities()
    {
        return $this->hasMany(RecruitingActivity::class);
    }
}
