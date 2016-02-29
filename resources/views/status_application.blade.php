@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Specific Application</div>
                <div class="panel-body">
                    <h3>Show personal Application depending on it's id</h3>
                    <div>
                        @if(Session::has('listArray'))
                        <h4>Personal information</h4>
                        @foreach(Session::get('listArray') as $object)
                        @if(Session::get('currentId') == $object->application_id && Session::has('currentId'))
                        <li><p>Applicant name: {{$object->first_name}} {{$object->last_name}}</p></li>
                        <li><p>Social security number: {{$object->ssn}}</p></li>
                        <li><p>Email: {{$object->email}}</p></li>
                        <li><p>Submission date: {{$object->submissionDate}}</p></li>
                        <li><p>Status: {{$object->status}}</p></li>
                        @endif
                        @endforeach
                        @endif
                    </div>
                    <div>
                        @if(Session::has('competenceArray'))
                        <h4>Personal Competences and years of work</h4>
                        @foreach(Session::get('competenceArray') as $object)
                        <li><p>Worked with {{$object->competence}} for {{$object->years}} years</p></li>
                        @endforeach
                        @endif
                    </div>
                    <div>
                        @if(Session::has('periodArray'))
                        <h4>Can only work on these periods</h4>
                        @foreach(Session::get('periodArray') as $object)
                        <li><p>Can work from {{$object->from_date}} to {{$object->to_date}}</p></li>
                        @endforeach
                        @endif
                    </div>
                    <form class="form-horizontal" role="form" method="POST">
                        {!! csrf_field() !!}
                        <div class="form">
                            {!! Form::open(array('url' => 'status_application')) !!}
                            {!! Form::label('Application id: ') !!}
                            {!! Form::text("appId") !!}
                            <div>
                                <input type="submit" name="display_information" value="Search">
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </form>
                    <div id='buttons'>
                        <br>
                        <form class="form-horizontal" role="form" method="POST">
                            {!! csrf_field() !!}
                            <div>
                                <input type="submit" name="accept" value="Accept">
                                <input type="submit" name="reject" value="Reject">
                            </div>
                            {!! Form::close() !!}
                        </form>
                    </div>
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