<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Log;
use Auth;
use App;
use Session;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('Language');
    }

    /**
     * This method is called when a post request is received from the 
     * corresponding page. The method checks which component was triggered and
     * calls the corresponding method
     * @param Request $request
     * @return type
     */
    public function postButton(Request $request) {
        if (Input::get('en')) {
            App::setLocale('en');
            Session::put('application_locale', 'en');
            $this->changeLanguage('en');
            return view('home');
        } elseif (Input::get('sv')) {
            App::setLocale('sv');
            Session::put('application_locale', 'sv');
            $this->changeLanguage('sv');
            return view('home');
        } elseif (Input::get('tr')) {
            App::setLocale('tr');
            Session::put('application_locale', 'tr');
            $this->changeLanguage('tr');
            return view('home');
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        Log::info('The currently logged in person: ' . Auth::user()->first_name . Auth::user()->last_name);
        return view('home');
    }

    /**
     * This function calls all the methods, which changes the localization on
     * database tables
     * @param type $language
     */
    private function changeLanguage($language) {
        $this->competenceLanguage($language);
        $this->roleLanguage($language);
        $this->statusLanguage($language);
    }

    /**
     * This function changes the language om the competences table in the database.
     * This is done by checking the language from the parameter and then make
     * an update in the table
     * @param type $language
     */
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

    /**
     * This function changes the language om the roles table in the database.
     * This is done by checking the language from the parameter and then make
     * an update in the table
     * @param type $language
     */
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

    /**
     * This function changes the status column in the Application_form table 
     * in the database, this depending on the parameter language
     * @param type $language
     */
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

    /**
     * This function takes the increment and the status of the current row. Then 
     * depending on the value of status it changes it to the correct language
     * @param type $status
     * @param type $increment
     */
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
