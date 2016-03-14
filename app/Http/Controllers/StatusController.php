<?php

namespace App\Http\Controllers;

use \Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Request as Req;
use Session;
use Auth;
use Log;
use DB;
use App;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class StatusController extends Controller {

    /**
     * This is the constructor of this class, which will call the auth 
     * middleware. This will deny access for all the visitor which hasn't 
     * logged in
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * This method will be called when a visitor access the status_application
     * page. This method will create and put the array that will be needed in 
     * other method in the session array
     * @return view
     */
    public function start() {

        if (!Session::has('competenceArray') || !Session::has('periodArray')) {

            $competenceArray = [];
            $periodArray = [];

            Session::put('competenceArray', $competenceArray);
            Session::put('periodArray', $periodArray);
        }

        return view('status_application');
    }

    /**
     * This method will be called when a post request is received from the 
     * status_application page. The method checks which component was triggered 
     * and calls the corresponding method. It will also log some information
     * that is needed to save
     * @param Request $request
     * @return view
     */
    public function postButton(Request $request) {
        if (Input::get('display_information')) {
            Session::put('currentId', Req::get('appId'));
            $this->fetchData($request);
            return view('status_application');
        } elseif (Input::get('accept')) {
            $this->statusUpdate('accepted', Session::get('currentId'));
            Log::info('The recruiter that performed the operation: ' . Auth::user()->first_name . Auth::user()->last_name);
            Log::info('The application with this id is accepted: ' . Session::get('currentId'));
            Session::forget('currentId');
            return view('status_success');
        } elseif (Input::get('reject')) {
            $this->statusUpdate('rejected', Session::get('currentId'));
            Log::info('The recruiter that performed the operation: ' . Auth::user()->first_name . Auth::user()->last_name);
            Log::info('The application with this id is rejected: ' . Session::get('currentId'));
            Session::forget('currentId');
            return view('status_success');
        }elseif (Input::get('en')) {
            App::setLocale('en');
            return view('status_application');
        }elseif (Input::get('sv')) {
            App::setLocale('sv');
            return view('status_application');
        }elseif (Input::get('tr')) {
            App::setLocale('tr');
            return view('status_application');
        }
    }

    /**
     * This method will fetch all the competences and period of work for a
     * specific person. This person will be the person that has the application
     * id that is entered by the visitor. The information will then be saved
     * in their corresponding arrays in the session array
     * @param Request $request
     * @return view
     */
    public function fetchData(Request $request) {
        $this->validate($request, [
            'appId' => 'required|max:2',
        ]);
        Session::forget('periodArray');
        Session::forget('competenceArray');
        DB::transaction(function () {
            $currentId = Req::get('appId');
            $competence_profile = \App\Competence_profile::where('application_id', $currentId)->get();
            foreach ($competence_profile as $profile) {
                $competence = \App\Competence::where('id', $profile->competence_id)->value('name');
                $competenceObj = new \App\CompetenceObj($competence, $profile->years_of_experience);
                Session::push('competenceArray', $competenceObj);
            }
            $periods = \App\Period::where('application_id', $currentId)->get();
            foreach ($periods as $period) {
                $periodObj = new \App\PeriodObj($period->from_date, $period->to_date);
                Session::push('periodArray', $periodObj);
            }
        });
        return view('status_application');
    }

    /**
     * This method receives the status of the application and it's id from 
     * the visitor. The new status will then be saved in the database
     * @param type $statusUpdate
     * @param type $id
     * @return view
     */
    public function statusUpdate($statusUpdate, $id) {
        Session::forget('periodArray');
        Session::forget('competenceArray');
        \App\application_form::where('id', $id)->update(['status' => $statusUpdate]);
        return view('status_success');
    }

    /**
     * This method converts a PHP file to a PDF document
     * @return stream to show in browser
     */
    public function convertPDF() {
        $pdf = PDF::loadView('pdf', Session::get('competenceArray'));
        return $pdf->stream();
    }

}
