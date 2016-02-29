@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Browse Applications</div>
                <div class="panel-body">
                    <h4>List Applications depending on search parameters</h4>
                    <form class="form-horizontal" role="form" method="POST">
                        {!! csrf_field() !!}
                        <div class="form">
                            {!! Form::open(array('url' => 'application_form')) !!}
                            {!! Form::label('Name: ') !!}
                            {!! Form::text('name') !!}
                            <div>
                                <input type="submit" name="display_name" value="Search">
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </form>
                    <form class="form-horizontal" role="form" method="POST">
                        {!! csrf_field() !!}
                        <div class="form">
                            {!! Form::open(array('url' => 'application_form')) !!}
                            {!! Form::label('Competence: ') !!}
                            {!! Form::text('competence') !!}
                            <div>
                                <input type="submit" name="display_competence" value="Search">
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </form>
                    <form class="form-horizontal" role="form" method="POST">
                        {!! csrf_field() !!}
                        <div class="form">
                            {!! Form::open(array('url' => 'application_form')) !!}
                            {!! Form::label('Date of Registration: ') !!}
                            {!! Form::text('registration') !!}
                            <div>
                                <input type="submit" name="display_registration" value="Search">
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </form>
                    <form class="form-horizontal" role="form" method="POST">
                        {!! csrf_field() !!}
                        <div class="form">
                            {!! Form::open(array('url' => 'application_form')) !!}
                            {!! Form::label('Date from: ') !!}
                            {!! Form::text('dateFrom') !!}
                            {!! Form::label('to: ') !!}
                            {!! Form::text('dateTo') !!}
                            <div>
                                <input type="submit" name="display_period" value="Search">
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </form>
                    <br>
                    <div>
                        @if(Session::has('listArray'))
                        @foreach(Session::get('listArray') as $object)
                        <li><p>Application id: {{$object->application_id}}, Name: {{$object->first_name}} {{$object->last_name}}, 
                                Registration date: {{$object->submissionDate}}, Application status: {{$object->status}}</p></li>
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