<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function tasks() {
        return $this->belongsTosMany(Task::class, 'tasks_tags', 'tag_id', 'task_id');
    }
}
