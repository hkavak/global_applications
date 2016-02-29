<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {

    public $timestamps = false;

    /**
     * This method is used to link the foreign key constraint between the user
     * table and the role table
     * @return link
     */
    public function users() {
        return $this->hasMany('\App\User');
    }

}
