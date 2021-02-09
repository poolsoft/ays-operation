<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static find($primaryKey)
 */
class Task extends Model
{
    use HasFactory, SoftDeletes;

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function checklistItems()
    {
        return $this->hasMany(ChecklistItem::class);
    }

    public function timesheets()
    {
        return $this->hasMany(Timesheet::class);
    }

    public function notes()
    {
        return $this->morphMany(Note::class, 'relation');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'relation');
    }

    public function milestone()
    {
        return $this->belongsTo(Milestone::class);
    }
}
