<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get all the tasks for the user
     */
     public function tasks() {
         return $this->hasMany(Task::class);
     }

     /**
      * Get all the projects for the user
      */
      public function projects() {
          return $this->hasMany(Project::class);
      }

}
