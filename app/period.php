<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Period extends Model {

    public $timestamps = false;

    /**
     * This method is used to link the foreign key constraint between the 
     * period table and the application_form table
     * @return link
     */
    public function application_forms() {
        return $this->belongsToMany('\App\application_form');
    }

}
