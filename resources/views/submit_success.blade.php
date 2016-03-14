@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('localization.subForm') }}</div>

                <div class="panel-body">
                    <p>{{ trans('localization.hej') }} {{ Auth::user()->first_name }}, {{ trans('localization.formMess') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection