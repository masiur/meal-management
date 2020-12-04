@extends('layouts.default')
@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('includes.alert')
            <section class="panel">
                <header class="panel-heading">
                    {{ $title }}
                    <span class="pull-right">

                            <a class="btn btn-success btn-sm" href="{{ URL::route('member.index') }}">All Members</a>

					</span>
                </header>
                <div class="panel-body">
                    {{ Form::open(array('route' => 'member.store', 'class' => 'form-horizontal','files' => true)) }}


                    <div class="form-group">
                        {{ Form::label('name', 'Name : ', array('class' => 'col-md-2 control-label')) }}
                        <div class="col-md-4">
                            {{ Form::text('name', null, array('class' => 'form-control',  'placeholder' => 'Name', 'required')) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('email', 'Email : ', array('class' => 'col-md-2 control-label')) }}
                        <div class="col-md-4">
                            {{ Form::text('email', null, array('class' => 'form-control',  'placeholder' => 'someone@example.com', 'required')) }}
                        </div>
                    </div>

                     <div class="form-group">
                        {{ Form::label('mobile', 'Mobile Number : ', array('class' => 'col-md-2 control-label')) }}
                        <div class="col-md-4">
                            {{ Form::text('mobile', null, array('class' => 'form-control',  'placeholder' => '017xxxxxxxx', 'required')) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('address', 'Address : ', array('class' => 'col-md-2 control-label')) }}
                        <div class="col-md-4">
                            {{ Form::text('address', null, array('class' => 'form-control',  'placeholder' => 'Room 13, West Side, Royal Flat, Sylhet', 'required')) }}
                        </div>
                    </div>
     

                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            {{ Form::submit('Submit', array('class' => 'btn btn-primary')) }}
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
                
            </section>
        </div>
    </div>
@stop



@section('style')
    {{ HTML::style('css/chosen_dropdown/chosen.css') }}
    {{ HTML::style('rename/css/fileinput.min.css') }}

@stop



@section('script')

    {{ HTML::script('js/chosen_dropdown/chosen.jquery.min.js') }}
    {{ HTML::script('rename/js/plugins/canvas-to-blob.min.js') }}
    {{ HTML::script('rename/js/fileinput_locale_<lang>.js') }}
    {{ HTML::script('rename/js/fileinput.min.js') }}
    {{ HTML::script('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js') }}

   
    <!-- image drag&drop and upload plugin  -->

    <script>
    $(document).on('ready', function() {
        $("#input-4").fileinput({showCaption: false});
    });
    </script>    
    
@stop
