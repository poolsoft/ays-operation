<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static whereBetween(string $string, array $array)
 * @method static select(\Illuminate\Database\Query\Expression $raw)
 * @method static selectRaw(string $string)
 * @method static where($columns, $parameter)
 */
class JobAnalysis extends Model
{
    use HasFactory, SoftDeletes;

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
