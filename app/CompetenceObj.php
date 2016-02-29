<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App;

/**
 * Description of CompetenceObj
 *
 * @author Hasan
 */
class CompetenceObj {

    public $competence;
    public $years;

    /**
     * This constructor is used to create a competence object that includes 
     * the given competence and year
     * @param type $competence
     * @param type $years
     */
    public function __construct($competence, $years) {
        $this->competence = $competence;
        $this->years = $years;
    }

}
