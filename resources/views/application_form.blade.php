@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('localization.applicationForm') }}</div>
                <div class="panel-body">
                    <h4>{{ trans('localization.competenceHeader') }}</h4>
                    <form class="form-horizontal" role="form" method="POST">
                        {!! csrf_field() !!}
                        <div class="form">
                            {!! Form::open(array('url' => 'application_form')) !!}
                            {{ trans('localization.competenceLabel') }}
                            {!! Form::select('competence', Session::get('competences')) !!}
                            {{ trans('localization.yearsLabel') }}
                            {!! Form::text('years') !!}
                            <div>
                                <input type="submit" name="save_comp" value="{{ trans('localization.save') }}">
                            </div>
                            {!! Form::close() !!}

                            @if(Session::has('competenceArray'))
                            @foreach(Session::get('competenceArray') as $object)
                            <li><p>{{ trans('localization.competenceText',['competence' => $object->competence, 'years' => $object->years]) }}</p></li>
                            @endforeach
                            @endif
                        </div>
                        <br>
                        <h4>{{ trans('localization.periodHeader') }}</h4>
                        <form class="form-horizontal" role="form" method="POST">
                            {!! csrf_field() !!}
                            <div class="form">
                                {!! Form::open(array('url' => 'application_form')) !!}
                                {{ trans('localization.fromLabel') }}
                                {!! Form::text('from_date') !!}
                                {{ trans('localization.toLabel') }}
                                {!! Form::text('to_date') !!}
                                <div>
                                    <input type="submit" name="save_period" value="{{ trans('localization.save') }}">
                                </div>
                                {!! Form::close() !!}

                                @if(Session::has('periodArray'))
                                @foreach(Session::get('periodArray') as $object)
                                <li><p>{{ trans('localization.periodText',['fromDate' => $object->from_date, 'toDate' => $object->to_date]) }}</p></li>
                                @endforeach
                                @endif
                            </div>
                                @if($errors->any())
                                   {!! implode('', $errors->all('<li style="color:red">:message</li>')) !!}
                                @endif
                            <div>
                                <br>
                                <div id="buttons">
                                    <form class="form-horizontal" role="form" method="POST">
                            {!! csrf_field() !!}
                            <input type="submit" name="submit" value="{{ trans('localization.submitForm') }}">
                            <input type="submit" name="cancel" value="{{ trans('localization.cancel') }}">
                                    </form>
                                </div>
                            </div>
                       </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
