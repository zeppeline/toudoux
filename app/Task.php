<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Carbon\Carbon;

class Task extends Model
{
    protected $fillable = ['body', 'due_date', 'project_id'];

    protected $dates = [
        'created_at',
        'updated_at',
        'due_date'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function tags() {
        return $this->belongsToMany(Tag::class, 'tasks_tags', 'task_id', 'tag_id');
    }

    public function getDueDateAttribute($value) {
        if($value === '0000-00-00') {
            return false;
        }
        return Carbon::parse($value);
    }
}
