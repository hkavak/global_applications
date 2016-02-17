@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Application Form</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/application_form') }}">
                        {!! csrf_field() !!}
                        <div class="form">
                            {!! Form::open(array('url' => 'application_form')) !!}
                            {!! Form::label('Select Competence: ') !!}
                            {!! Form::select('competence', $competences) !!}
                            {!! Form::label('Years of experience: ') !!}
                            {!! Form::text('years') !!}
                            <div>
                            {!! Form::submit('Save') !!}
                            </div>
                            {!! Form::close() !!}
 
                        </div>
                        <?php echo $stack[1]; ?>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>
@endsection
