<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App;

/**
 * Description of ApplicationDTO
 *
 * @author Hasan
 */
class ApplicationDTO {

    public $application_id;
    public $first_name;
    public $last_name;
    public $ssn;
    public $email;
    public $submissionDate;
    public $status;

    /**
     * This contructor is used to store all personal information that is 
     * possible to store and will be needed for further access
     * @param type $application_id
     * @param type $first_name
     * @param type $last_name
     * @param type $ssn
     * @param type $email
     * @param type $submissionDate
     * @param type $status
     */
    public function __construct($application_id, $first_name, $last_name, $ssn, $email, $submissionDate, $status) {
        $this->application_id = $application_id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->ssn = $ssn;
        $this->email = $email;
        $this->submissionDate = $submissionDate;
        $this->status = $status;
    }

}
