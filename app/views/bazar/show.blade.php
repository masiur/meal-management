@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            @include('includes.alert')
            <section class="panel">
                <header class="panel-heading clearfix">
                    {{ $title }}
                    <span class="pull-right">

                            <a class="btn btn-success btn-sm btn-new-user" href="{{ URL::route('stocks.create') }}">Add New Card</a>

                    </span>
                </header>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h4><b> Card Type:</b> {{ $stock->card->title }}</h4><br>
                            <h4><b> Stock Status: </b> {{ $status[$stock->status] }}</h4><br>
                            <h4><b> Owner( If Any) : </b>@if(!empty($stock->user_id))
                                                             {{ $stock->user->userInfo->name }}
                                                        @else
                                                        No Owner
                                                        @endif</h4><br>
                        </div>
                        <div class="col-md-4">
                            {{ HTML::image($stock->img_link, $stock->card->title, ['class'=> 'img-responsive', 'width' => '400' , 'height' => '300']) }}
                        </div>
                    
                    </div>
                
                    <span class="pull-left">
                        <a class="btn btn-xs btn-success btn-edit" href="{{ URL::route('stocks.edit', array('id' => $stock->id)) }}">Edit This stock</a>

                    </span>
                    <br>
                    <span class="pull-right">
                        <a href="#" class="btn btn-danger btn-xs btn-archive deleteBtn" data-toggle="modal" data-target="#deleteConfirm" deleteId="{{ $stock->id }}">Delete This Card</a>

                    </span>
                </div>
            </section>
        </div>
    </div>

<!-- Modal -->
    <div class="modal fade" id="deleteConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Confirmation</h4>
                </div>
                <div class="modal-body">
                    Are you sure to delete?
                </div>
                <div class="modal-footer">
                    {{ Form::open(array('route' => array('cards.delete', 0), 'method'=> 'delete', 'class' => 'deleteForm')) }}
                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                    {{ Form::submit('Yes, Delete', array('class' => 'btn btn-success')) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>


@stop




@section('script')


    <script type="text/javascript" charset="utf-8">
        $(document).ready(function() {
            $.get("http://ipinfo.io", function(response) {
                console.log(response.city, response.country,response.region);
            }, "jsonp");

            $(document).on("click", ".deleteBtn", function() {
                var deleteId = $(this).attr('deleteId');
                var url = "<?php echo URL::route('stocks.index'); ?>";
                $(".deleteForm").attr("action", url+'/'+deleteId);
            });
        });
    </script>

@stop


