<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'first_name', 'last_name'
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
     * returns all the users addresses
     *
     * @param $query
     * @param $id
     * @return $this
     */
    public function scopeUserAddresses($query, $id)
    {
        return $query->find($id)
            ->addresses()
            ->with('state')
            ->get();
    }

    /**
     * returns the users full name
     *
     * @return string
     */
    public function fullName()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * A user has many addresses
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses()
    {
        return $this->hasMany('App\Address');
    }

    /**
     * A user has many orders
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    /**
     * User can have one role
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    /**
     * Check if a user has a particular role
     *
     * @param $name
     * @return bool
     */
    public function hasRole($name)
    {
        foreach ($this->roles as $role)
        {

            if ($role->name == $name) return true;
        }
        return false;
    }

    /**
     * Check if user has a role
     *
     * @return bool
     */
    public function hasNoRole()
    {
        if(empty($this->roles->first()->name))
        {
            return true;
        }

        return false;
    }

    /**
     * Assigns a role to a user
     *
     * @param $role
     * @return void
     */
    public function assignRole(Role $role)
    {
        $this->roles()->attach($role->id);
    }


    /**
     * Removes a role from a user
     *
     * @param  Role $role
     * @return void
     */
    public function removeRole(Role $role)
    {
        $this->roles()->detach($role);
    }
}
