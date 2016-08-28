<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['body', 'due_date'];

    protected $dates = [
        'created_at',
        'updated_at',
        'due_date'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
