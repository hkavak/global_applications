<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Competence_profile extends Model {

    public $timestamps = false;

    /**
     * This method is used to link the foreign key constraint between the 
     * competence_profile table and the application_form table
     * @return link
     */
    public function application_forms() {
        return $this->belongsTo('\App\Application_form');
    }

    /**
     * This method is used to link the foreign key constraint between the
     * competence_profile table and the competence table
     * @return link
     */
    public function competences() {
        return $this->belongsTo('\App\Competence');
    }

}
