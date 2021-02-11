<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static find($primaryKey)
 */
class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = ['status', 'progress'];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function timesheets()
    {
        return $this->hasManyThrough(Timesheet::class, Task::class);
    }

    public function milestones()
    {
        return $this->hasMany(Milestone::class);
    }

    public function files()
    {
        return $this->morphMany(File::class, 'relation');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'relation');
    }

    public function notes()
    {
        return $this->morphMany(Note::class, 'relation');
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class);
    }

    public function getStatusAttribute()
    {
        return ProjectStatus::find($this->status_id)->name;
    }

    public function getProgressAttribute()
    {
        return count($this->tasks) > 0 ?
            number_format(((count($this->tasks()->where('status_id', 5)->get()) / count($this->tasks)) * 100),2,'.',',') :
            0;
    }
}
