<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecruitingStepSubStep extends Model
{
    use HasFactory, SoftDeletes;

    public function step()
    {
        return $this->belongsTo(RecruitingStep::class, 'recruiting_step_id', 'id');
    }
}
