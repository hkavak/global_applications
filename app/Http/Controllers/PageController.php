<?php

namespace App\Http\Controllers;
use \Illuminate\Support\Facades\Request as Request;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PageController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function home() {

        $competences = \App\Competence::lists('name');
        
        return view('application_form',  compact('competences'));
    }
    public function saveForm(){
        $stack = array("$competence->name", $year);
        $competence_id = Request::get('competence');
        $competence = \App\Competence::findOrNew($competence_id + 1);
        echo $competence->name;
        echo $year = Request::get('years');
        return view('application_form',  compact('stack','competences'));
    }

}
