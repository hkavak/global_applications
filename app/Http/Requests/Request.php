<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest {

    /**
     * This method gives a message for a specific string and it's corresponding
     * requirement
     * @return type
     */
    public function messages() {
        return [
            'years' => 'required|max:3',
            'from_date' => 'required|date_format:Y-m-d',
            'to_date' => 'required|date_format:Y-m-d|after:from_date',
            'name' => 'required',
            'competence' => 'required',
            'registration' => 'required|date_format:Y-m-d',
            'dateFrom' => 'required|date_format:Y-m-d',
            'dateTo' => 'required|date_format:Y-m-d|after:from_date',
            'appId' => 'required'
        ];
    }

}
