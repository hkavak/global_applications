<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Competence extends Model {

    public $timestamps = false;

    /**
     * This method is used to link the foreign key constraint between the 
     * competence_profile table and the competence table
     * @return link
     */
    public function competence_profiles() {
        return $this->hasMany('\App\Competence_profile');
    }

}
