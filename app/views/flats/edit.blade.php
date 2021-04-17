@extends('layouts.default')
@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('includes.alert')
            <section class="panel">
                <header class="panel-heading">
                    {{ $title }}
                    <span class="pull-right">
                            <a class="btn btn-success btn-sm" href="{{ URL::route('user.index') }}">All Flats</a><br>
					</span>
                </header>
                <div class="panel-body">
                   

                    {{Form::model($flat,['route' => ['user.update',$flat->id], 'class' => 'form-horizontal', 'method' => 'put', 'files' => true ])}}

                    
                        <div class="form-group">
                        {{ Form::label('flat_short_name', 'Flat User Name : ', array('class' => 'col-md-2 control-label')) }}
                        <div class="col-md-4">
                            {{ Form::text('flat_short_name', null, array('class' => 'form-control',  'placeholder' => 'Name', 'required')) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('flat_full_name', 'Flat Full Name : ', array('class' => 'col-md-2 control-label')) }}
                        <div class="col-md-4">
                            {{ Form::text('flat_full_name', null, array('class' => 'form-control',  'placeholder' => 'Name', 'required')) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('email', 'Manager Email : ', array('class' => 'col-md-2 control-label')) }}
                        <div class="col-md-4">
                            {{ Form::text('email', null, array('class' => 'form-control',  'placeholder' => 'someone@example.com', 'required')) }}
                        </div>
                    </div>

                     <div class="form-group">
                        {{ Form::label('flat_mobile_number', 'Contact Number : ', array('class' => 'col-md-2 control-label')) }}
                        <div class="col-md-4">
                            {{ Form::text('flat_mobile_number', null, array('class' => 'form-control',  'placeholder' => '017xxxxxxxx', 'required')) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('flat_address', 'Contact Address : ', array('class' => 'col-md-2 control-label')) }}
                        <div class="col-md-4">
                            {{ Form::text('flat_address', null, array('class' => 'form-control',  'placeholder' => 'Royal Flat, Sylhet', 'required')) }}
                        </div>
                    </div>
                    
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                {{ Form::submit('Update', array('class' => 'btn btn-primary')) }}
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
    {{ HTML::script('js/ckeditor/ckeditor.js') }}
    {{ HTML::script('rename/js/plugins/canvas-to-blob.min.js') }}
    {{ HTML::script('rename/js/fileinput_locale_<lang>.js') }}
    {{ HTML::script('rename/js/fileinput.min.js') }}
    {{ HTML::script('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js') }}

    <<script>
    $(document).on('ready', function() {
        $("#input-4").fileinput({showCaption: false});
    });
    </script>

    <script>
        $(document).on('ready', function() {
            $("#input-4").click(function(){
                $("#preimg").fadeOut("1000");
                
              //  $("#div2").fadeOut("slow");
             //   $("#div3").fadeOut(3000);
            });
        });
    </script>

@stop