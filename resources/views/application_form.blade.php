@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Application Form</div>
                <div class="panel-body">
                    <h4>Competence and experience</h4>
                    <form class="form-horizontal" role="form" method="POST">
                        {!! csrf_field() !!}
                        <div class="form">
                            {!! Form::open(array('url' => 'application_form')) !!}
                            {!! Form::label('Select Competence: ') !!}
                            {!! Form::select('competence', Session::get('competences')) !!}
                            {!! Form::label('Years of experience: ') !!}
                            {!! Form::text('years') !!}
                            <div>
                                <input type="submit" name="save_comp" value="Save">
                            </div>
                            {!! Form::close() !!}

                            @if(Session::has('competenceArray'))
                            @foreach(Session::get('competenceArray') as $object)
                            <li><p>Worked with {{$object->competence}} for {{$object->years}} years</p></li>
                            @endforeach
                            @endif
                        </div>
                        <br>
                        <h4>Select period of work</h4>
                        <form class="form-horizontal" role="form" method="POST">
                            {!! csrf_field() !!}
                            <div class="form">
                                {!! Form::open(array('url' => 'application_form')) !!}
                                {!! Form::label('From: ') !!}
                                {!! Form::text('from_date') !!}
                                {!! Form::label('To: ') !!}
                                {!! Form::text('to_date') !!}
                                <div>
                                    <input type="submit" name="save_period" value="Save">
                                </div>
                                {!! Form::close() !!}

                                @if(Session::has('periodArray'))
                                @foreach(Session::get('periodArray') as $object)
                                <li><p>Can work from {{$object->from_date}} to {{$object->to_date}}</p></li>
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
                            <input type="submit" name="submit" value="Submit Form">
                            <input type="submit" name="cancel" value="Cancel">
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
