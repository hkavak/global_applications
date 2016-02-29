<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application_form extends Model {

    public $timestamps = false;

    /**
     * This method is used to link the foreign key constraint between the user
     * table and the application_form table
     * @return link
     */
    public function users() {
        return $this->belongsTo('\App\User');
    }

    /**
     * This method is used to link the foreign key constraint between the 
     * period table and the application_form table
     * @return link
     */
    public function periods() {
        return $this->belongsToMany('\App\Period');
    }

}
