<?php

namespace App\Http\Controllers;

use \Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Request as Req;
use DateTime;
use Session;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CheckController extends Controller {

    /**
     * Construktor which calls the middleware auth for login access
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * The method that calls when we access the check application page. 
     * Creates an array for the applications and puts it in the Session array
     * @return view
     */
    public function start() {

        if (!Session::has('listArray')) {

            $listArray = [];

            Session::put('listArray', $listArray);
        }
        return view('check_application');
    }

    /**
     * This method is called when a post request arrives from the check 
     * application page. The method checks which component was triggered and
     * calls the corresponding method
     * @param Request $request
     * @return view
     */
    public function postButton(Request $request) {
        if (Input::get('display_name')) {
            $this->fetchName($request);
            return view('check_application');
        } elseif (Input::get('display_competence')) {
            $this->fetchCompetence($request);
            return view('check_application');
        } elseif (Input::get('display_registration')) {
            $this->fetchRegistration($request);
            return view('check_application');
        } elseif (Input::get('display_period')) {
            $this->fetchPeriod($request);
            return view('check_application');
        }
    }

    /**
     * This method fetches the requested user and gets all his application that 
     * he has submitted. The application information is stored on a DTO which
     * is saved in an array in the session array
     * @param Request $request
     */
    private function fetchName(Request $request) {
        $this->validate($request, [
            'name' => 'required',
        ]);
        Session::forget('listArray');
        $name = Req::get('name');
        $users = \App\User::where('first_name', $name)->orWhere('last_name', $name)->get();
        foreach ($users as $user) {
            $listApplicants = \App\User::find($user->id)->application_forms()->get();
        }
        foreach ($listApplicants as $application) {
            $first_name = \App\User::where('id', $application->user_id)->value('first_name');
            $last_name = \App\User::where('id', $application->user_id)->value('last_name');
            $ssn = \App\User::where('id', $application->user_id)->value('ssn');
            $email = \App\User::where('id', $application->user_id)->value('email');
            $applicationDTO = new \App\ApplicationDTO($application->id, $first_name, $last_name, $ssn, $email, $application->date, $application->status);
            Session::push('listArray', $applicationDTO);
        }
    }

    /**
     * This method fetches the requested competence from the visitor and get's 
     * the corresponding applications that matches the competence. The data
     * that is retreved from the applications is stored on a DTO and then in the
     * session array
     * @param Request $request
     */
    private function fetchCompetence(Request $request) {
        $this->validate($request, [
            'competence' => 'required',
        ]);
        Session::forget('listArray');
        $competence_id = \App\Competence::where('name', Req::get('competence'))->value('id');
        $competence_profile = \App\Competence::find($competence_id)->competence_profiles()->get();
        foreach ($competence_profile as $profile) {
            $listApplication = \App\Application_form::where('id', $profile->application_id)->get();
            foreach ($listApplication as $application) {
                $first_name = \App\User::where('id', $application->user_id)->value('first_name');
                $last_name = \App\User::where('id', $application->user_id)->value('last_name');
                $ssn = \App\User::where('id', $application->user_id)->value('ssn');
                $email = \App\User::where('id', $application->user_id)->value('email');
                $applicationDTO = new \App\ApplicationDTO($application->id, $first_name, $last_name, $ssn, $email, $application->date, $application->status);
                Session::push('listArray', $applicationDTO);
            }
        }
    }

    /**
     * This method retrieves the visitors period of registratiion request and 
     * gets the corresponding applications. The application information is then
     * stored in a DTO, which will then be stored in the session array
     * @param Request $request
     */
    private function fetchRegistration(Request $request) {
        $this->validate($request, [
            'registration' => 'required|date_format:Y-m-d',
        ]);
        Session::forget('listArray');
        $date = Req::get('registration');
        $listApplications = \App\Application_form::where('date', $date)->get();
        foreach ($listApplications as $application) {
            $first_name = \App\User::where('id', $application->user_id)->value('first_name');
            $last_name = \App\User::where('id', $application->user_id)->value('last_name');
            $ssn = \App\User::where('id', $application->user_id)->value('ssn');
            $email = \App\User::where('id', $application->user_id)->value('email');
            $applicationDTO = new \App\ApplicationDTO($application->id, $first_name, $last_name, $ssn, $email, $application->date, $application->status);
            Session::push('listArray', $applicationDTO);
        }
    }

    /**
     * This method fetches the visitors search period and then tryes to match it
     * with all of the applicants available work periods. If it matches the 
     * applicants application information will be put in a DTO and stored in 
     * the array currently stored in the session array
     * @param Request $request
     */
    private function fetchPeriod(Request $request) {
        $this->validate($request, [
            'dateFrom' => 'required|date_format:Y-m-d',
            'dateTo' => 'required|date_format:Y-m-d|after:dateFrom']);

        Session::forget('listArray');
        $fromDate = new \DateTime(Req::get('dateFrom'));
        $toDate = new \DateTime(Req::get('dateTo'));
        $allApplications = \App\Application_form::all();
        foreach ($allApplications as $application) {
            $periods = \App\Period::where('application_id', $application->id)->get();
            foreach ($periods as $period) {
                if ($this->periodCheck(new \DateTime($period->from_date), new \DateTime($period->to_date), $fromDate, $toDate) == 1) {
                    $first_name = \App\User::where('id', $application->user_id)->value('first_name');
                    $last_name = \App\User::where('id', $application->user_id)->value('last_name');
                    $ssn = \App\User::where('id', $application->user_id)->value('ssn');
                    $email = \App\User::where('id', $application->user_id)->value('email');
                    $applicationDTO = new \App\ApplicationDTO($application->id, $first_name, $last_name, $ssn, $email, $application->date, $application->status);
                    Session::push('listArray', $applicationDTO);
                }
            }
        }
    }

    /**
     * The method checks if the two first parameters is in the period of the 
     * last two parameters. If so the function will return 1, or otherwise 
     * nothing
     * @param DateTime $currentStartDate
     * @param type $currentEndDate
     * @param DateTime $startDate
     * @param DateTime $endDate
     * @return int
     */
    function periodCheck(DateTime $currentStartDate, $currentEndDate, DateTime $startDate, DateTime $endDate) {
        return $currentStartDate <= $startDate && $currentEndDate >= $endDate;
    }

}