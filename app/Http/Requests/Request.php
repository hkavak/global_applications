<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    public function messages() {
    return [
        'years' => 'required|max:3',
        'from_date' => 'required|date_format:Y-m-d',
        'to_date' => 'required|date_format:Y-m-d|after:from_date'
    ];
    }
}
