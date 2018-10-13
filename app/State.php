<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'abbreviation'
    ];

    /**
     * The created at and updated at must be hidden
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
