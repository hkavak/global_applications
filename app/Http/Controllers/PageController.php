<?php

namespace App\Http\Controllers;

use \Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Request as Req;
use Session;
use Auth;
use DB;
use App;
use Lang;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PageController extends Controller {

    /**
     * This is the constructor of this class, which includes the middleware auth
     * so that non logged in personal can't access this class
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * This method is the first that will be called when we access the 
     * application_form page. This method will, if not already existing create
     * three arrays which will be stored in the session array for further use
     * @return view
     */
    public function home() {

        $comp = \App\Competence::lists('name');
        if (!Session::has('competenceArray') || !Session::has('periodArray') || !Session::has('competences')) {

            $competenceArray = [];
            $periodArray = [];
            $competences = [];

            foreach ($comp as $current_comp) {
                $competences[] = $current_comp;
            }

            Session::put('competenceArray', $competenceArray);
            Session::put('periodArray', $periodArray);
            Session::put('competences', $competences);
        }

        return view('application_form');
    }

    /**
     * This method is called when a post request is received from the 
     * corresponding page. The method checks which component was triggered and
     * calls the corresponding method
     * @param Request $request
     * @return view
     */
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
        } elseif (Input::get('en')) {
            App::setLocale('en');
            Lang::setFallback('en');
            $this->changeLanguage('en');
            return view('application_form');
        } elseif (Input::get('sv')) {
            App::setLocale('sv');
            Lang::setFallback('sv');
            $this->changeLanguage('sv');
            return view('application_form');
        } elseif (Input::get('tr')) {
            App::setLocale('tr');
            Lang::setFallback('tr');
            $this->changeLanguage('tr');
            return view('application_form');
        }
    }

    /**
     * This method fetches the visitors competence and year he/she has filled
     * in on the form. This will then be saved on an object which will then be
     * pushed up in the session array
     * @param Request $request
     * @return view
     */
    private function competenceForm(Request $request) {
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

    /**
     * This method fetches the visitors period of available work he/she has 
     * filled in on the form. This will the be saved in an object and push in
     * to it's corresponding array in the session array
     * @param Request $request
     * @return view
     */
    private function periodForm(Request $request) {
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

    /**
     * This method will be creating an application row in the database and fill
     * it upp with the visitors information. It will also create the required
     * foreign key linked tables and save all of them in the database
     * @return view
     */
    private function submitForm() {
        DB::transaction(function () {
            $application_form = new \App\Application_form;
            $application_form->user_id = Auth::user()->id;
            $application_form->status = 'pending';
            $application_form->date = date('Y-m-d');
            $application_form->save();

            $application_id = $application_form->id;
            foreach (Session::pull('competenceArray') as $comp) {
                $competence_profile = new \App\Competence_profile;
                $competence_profile->application_id = $application_id;
                $competence_profile->competence_id = \App\Competence::where('name', $comp->competence)->value('id');
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
        });
        return view('submit_success');
    }

    /**
     * This method will erase the arrays that would be used to to save period 
     * and competence from the session array
     * @return view
     */
    private function cancelForm() {
        Session::forget('competenceArray');
        Session::forget('periodArray');
        return view('application_form');
    }

    private function changeLanguage($language) {
        $this->competenceLanguage($language);
        $this->roleLanguage($language);
        $this->statusLanguage($language);
    }

    private function competenceLanguage($language) {
        $competences = \App\Competence::all();
        $increment = 0;
        if ($language == 'en') {
            foreach ($competences as $competence) {
                $increment++;
                \App\Competence::where('id', $increment)->update(['name' => trans_choice('localization.competences', $increment)]);
            }
        } elseif ($language == 'sv') {
            foreach ($competences as $competence) {
                $increment++;
                \App\Competence::where('id', $increment)->update(['name' => trans_choice('localization.competences', $increment)]);
            }
        } elseif ($language == 'tr') {
            foreach ($competences as $competence) {
                $increment++;
                \App\Competence::where('id', $increment)->update(['name' => trans_choice('localization.competences', $increment)]);
            }
        }
    }

    private function roleLanguage($language) {
        $roles = \App\Role::all();
        $increment = 0;
        if ($language == 'en') {
            foreach ($roles as $role) {
                $increment++;
                \App\Role::where('id', $increment)->update(['name' => trans_choice('localization.roles', $increment)]);
            }
        } elseif ($language == 'sv') {
            foreach ($roles as $role) {
                $increment++;
                \App\Role::where('id', $increment)->update(['name' => trans_choice('localization.roles', $increment)]);
            }
        } elseif ($language == 'tr') {
            foreach ($roles as $role) {
                $increment++;
                \App\Role::where('id', $increment)->update(['name' => trans_choice('localization.roles', $increment)]);
            }
        }
    }

    private function statusLanguage($language) {
        $applications = \App\Application_form::all();
        $increment = 0;
        if ($language == 'en') {
            foreach ($applications as $application) {
                $status = $application->status;
                $increment++;
                $this->decideStatus($status, $increment);
            }
        } elseif ($language == 'sv') {
            foreach ($applications as $application) {
                $status = $application->status;
                $increment++;
                $this->decideStatus($status, $increment);
            }
        } elseif ($language == 'tr') {
            foreach ($applications as $application) {
                $status = $application->status;
                $increment++;
                $this->decideStatus($status, $increment);
            }
        }
    }

    private function decideStatus($status, $increment) {
        if ($status == 'pending' || $status == 'avvaktar' || $status == 'degerlendiriliyor') {
            \App\Application_form::where('id', $increment)->update(['status' => trans('localization.pending')]);
        } elseif ($status == 'accepted' || $status == 'accepterat' || $status == 'Kabul edildi') {
            \App\Application_form::where('id', $increment)->update(['status' => trans('localization.accepted')]);
        } elseif ($status == 'rejected' || $status == 'avböjt' || $status == 'Kabul edilmedi') {
            \App\Application_form::where('id', $increment)->update(['status' => trans('localization.rejected')]);
        }
    }

}
