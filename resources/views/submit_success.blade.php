@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Submitted Form</div>

                <div class="panel-body">
                    <p>Hi {{ Auth::user()->first_name }}, We have received your application. We hope to 
                    see you soon </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection