@extends('layouts.default')
@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('includes.alert')
            <section class="panel">
                <header class="panel-heading">
                    {{ $title }}
                    <span class="pull-right">
                            <a class="btn btn-success btn-sm" href="{{ URL::route('month.index') }}">All Months</a><br>
					</span>
                </header>
                <div class="panel-body">
                   

                    {{Form::model($month,['route' => ['month.update',$month->id], 'class' => 'form-horizontal', 'method' => 'put', 'files' => true ])}}

                    
                        <div class="form-group">
                        {{ Form::label('name', 'Name : ', array('class' => 'col-md-2 control-label')) }}
                        <div class="col-md-4">
                            {{ Form::text('name', null, array('class' => 'form-control',  'placeholder' => 'Name', 'required')) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('cost', 'Cost : ', array('class' => 'col-md-2 control-label')) }}
                        <div class="col-md-4">
                            {{ Form::text('cost', null, array('class' => 'form-control',  'placeholder' => 'Cost', 'required')) }}
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