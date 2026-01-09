<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'title',
        'description',
        'user_id',
    ];

    protected static function booted()
    {
        static::creating(function ($project) {
            if (empty($project->uuid)) {
                $project->uuid = (string) Str::uuid();
            }
        });
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
