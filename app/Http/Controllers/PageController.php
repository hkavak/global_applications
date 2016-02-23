<?php

namespace App\Http\Controllers;

use \Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Request as Req;
use Session;
use Auth;
use DB;
use View;

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

        $comp = \App\Competence::lists('name');
        $competenceArray = [];
        $periodArray = [];
        $competences = [];

        foreach ($comp as $current_comp) {
            $competences[] = $current_comp;
        }

        Session::put('competenceArray', $competenceArray);
        Session::put('periodArray', $periodArray);
        Session::put('competences', $competences);

        return view('application_form');
    }

    public function postButton(Request $request) {
        if (Input::get('save_comp')) {
            $this->competenceForm($request);
            return view('application_form');
        } elseif (Input::get('save_period')) {
            $this->periodForm($request);
            return view('application_form');
        } elseif (Input::get('submit')) {
            $this->submitForm();
            return view('submit_success');
        } elseif (Input::get('cancel')) {
            $this->cancelForm();
            return view('application_form');
        }
    }

    public function competenceForm(Request $request) {
        $this->validate($request, [
            'years' => 'required|max:3',
        ]);

        $competences = Session::get('competences');
        $competence = $competences[Req::get('competence')];
        $year = Req::get('years');

        $compObj = new \App\CompetenceObj($competence, $year);
        Session::push('competenceArray', $compObj);
        return view('application_form');
    }

    public function periodForm(Request $request) {
        $this->validate($request, [
            'from_date' => 'required|date_format:Y-m-d',
            'to_date' => 'required|date_format:Y-m-d|after:from_date',
        ]);

        $from_date = Req::get('from_date');
        $to_date = Req::get('to_date');
        $compObj = new \App\PeriodObj($from_date, $to_date);
        Session::push('periodArray', $compObj);
        return view('application_form');
    }

    public function submitForm() {
        $application_form = new \App\Application_form;
        $application_form->user_id = Auth::user()->id;$application_form->status = 'pending';
        $application_form->date = date('Y-m-d');
        $application_form->save();

        $application_id = $application_form->id;
        foreach (Session::pull('competenceArray') as $comp) {
            $competence_profile = new \App\Competence_profile;
            $competence_profile->application_id = $application_id;
            $competence_profile->competence_id = DB::table('competences')->where('name', $comp->competence)->value('id');
            $competence_profile->years_of_experience = $comp->years;
            $competence_profile->save();
        }
        foreach (Session::pull('periodArray') as $comp) {
            $periods = new \App\Period;
            $periods->application_id = $application_id;
            $periods->from_date = $comp->from_date;
            $periods->to_date = $comp->to_date;
            $periods->save();
        }
        return view('submit_success');
    }

    public function cancelForm() {
        Session::forget('competenceArray');
        Session::forget('periodArray');
        return view('application_form');
    }

}
