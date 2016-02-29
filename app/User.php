<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'ssn', 'role_id', 'username', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * This method is used to link the foreign key constraint between the user
     * table and the application_form table
     * @return link
     */
    public function application_forms() {
        return $this->hasMany('\App\Application_form');
    }

    /**
     * This method is used to link the foreign key constraint between the user
     * table and the role table
     * @return link
     */
    public function roles() {
        return $this->belongsTo('\App\role');
    }

}
