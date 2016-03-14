@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('localization.browseApplication') }}</div>
                <div class="panel-body">
                    <h4>{{ trans('localization.listSearch') }}</h4>
                    <form class="form-horizontal" role="form" method="POST">
                        {!! csrf_field() !!}
                        <div class="form">
                            {!! Form::open(array('url' => 'application_form')) !!}
                            {{ trans('localization.name') }}
                            {!! Form::text('name') !!}
                            <div>
                                <input type="submit" name="display_name" value="{{ trans('localization.search') }}">
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </form>
                    <form class="form-horizontal" role="form" method="POST">
                        {!! csrf_field() !!}
                        <div class="form">
                            {!! Form::open(array('url' => 'application_form')) !!}
                            {{ trans('localization.competence') }}
                            {!! Form::text('competence') !!}
                            <div>
                                <input type="submit" name="display_competence" value="{{ trans('localization.search') }}">
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </form>
                    <form class="form-horizontal" role="form" method="POST">
                        {!! csrf_field() !!}
                        <div class="form">
                            {!! Form::open(array('url' => 'application_form')) !!}
                            {{ trans('localization.dateReg') }}
                            {!! Form::text('registration') !!}
                            <div>
                                <input type="submit" name="display_registration" value="{{ trans('localization.search') }}">
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </form>
                    <form class="form-horizontal" role="form" method="POST">
                        {!! csrf_field() !!}
                        <div class="form">
                            {!! Form::open(array('url' => 'application_form')) !!}
                            {{ trans('localization.dateF') }}
                            {!! Form::text('dateFrom') !!}
                            {{ trans('localization.toLabel') }}
                            {!! Form::text('dateTo') !!}
                            <div>
                                <input type="submit" name="display_period" value="{{ trans('localization.search') }}">
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </form>
                    <br>
                    <div>
                        @if(Session::has('listArray'))
                        @foreach(Session::get('listArray') as $object)
                        <li><p>{{ trans('localization.searchText',['applicationId' => $object->application_id, 'SnameF' => $object->first_name,
                        'SnameL' => $object->last_name,'subbmissionDate' => $object->submissionDate, 'appStatus' => $object->status]) }}</p></li>
                        @endforeach
                        @endif
                    </div>
                    @if($errors->any())
                    {!! implode('', $errors->all('<li style="color:red">:message</li>')) !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection