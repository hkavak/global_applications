@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('localization.specApp') }}</div>
                <div class="panel-body">
                    <h3>{{ trans('localization.showPers') }}</h3>
                    <div>
                        @if(Session::has('listArray'))
                        @foreach(Session::get('listArray') as $object)
                        @if(Session::get('currentId') == $object->application_id && Session::has('currentId'))
                        <h4>{{ trans('localization.persInfo') }}</h4>
                        <li><p>{{ trans('localization.applName',['firstN' => $object->first_name, 'lastN' => $object->last_name]) }}</p></li>
                        <li><p>{{ trans('localization.applSsn',['ssn' => $object->ssn]) }}</p></li>
                        <li><p>{{ trans('localization.applEmail',['email' => $object->email]) }}</p></li>
                        <li><p>{{ trans('localization.applSd',['Sd' => $object->submissionDate]) }}</p></li>
                        <li><p>{{ trans('localization.applStatus',['status' => $object->status]) }}</p></li>
                        @endif
                        @endforeach
                        @endif
                    </div>
                    <div>
                        @if(Session::has('competenceArray'))
                        <h4>{{ trans('localization.persCom') }}</h4>
                        @foreach(Session::get('competenceArray') as $object)
                        <li><p>{{ trans('localization.applYear',['appCom' => $object->competence, 'appYear' => $object->years]) }}</p></li>
                        @endforeach
                        @endif
                    </div>
                    <div>
                        @if(Session::has('periodArray'))
                        <h4>{{ trans('localization.applPeriod') }}</h4>
                        @foreach(Session::get('periodArray') as $object)
                        <li><p>{{ trans('localization.applPeriod',['appFrom' => $object->from_date, 'appTo' => $object->to_date]) }}</p></li>
                        @endforeach
                        @endif
                    </div>
                    <form class="form-horizontal" role="form" method="POST">
                        {!! csrf_field() !!}
                        <div class="form">
                            {!! Form::open(array('url' => 'status_application')) !!}
                            {{ trans('localization.aId') }}
                            {!! Form::text("appId") !!}
                            <div>
                                <input type="submit" name="display_information" value="{{ trans('localization.search') }}">
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </form>
                    <div id='buttons'>
                        <br>
                        <form class="form-horizontal" role="form" method="POST">
                            {!! csrf_field() !!}
                            <div>
                                <input type="submit" name="accept" value="{{ trans('localization.accept') }}">
                                <input type="submit" name="reject" value="{{ trans('localization.reject') }}">
                            </div>
                            {!! Form::close() !!}
                        </form>
                    </div>
                    <br>
                    <form class="form-horizontal" role="form" action="pdf">
                        {!! csrf_field() !!}
                        <input type="submit" name="pdf" value="{{ trans('localization.pdf') }}">
                    </form>
                </div>
                <br>
                @if($errors->any())
                {!! implode('', $errors->all('<li style="color:red">:message</li>')) !!}
                @endif
            </div>
        </div>
    </div>
</div>
@endsection