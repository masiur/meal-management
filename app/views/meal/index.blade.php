@extends('layouts.default')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            @include('includes.alert')
            <section class="panel">
                <header class="panel-heading clearfix">
                    {{ $title }}
                    <span class="pull-right">

                            <a class="btn btn-success btn-sm btn-new-user" href="{{ URL::route('month.meal.create', ['id' => $id]) }}">Create New Entry</a>

                    </span>
                </header>
                <div class="panel-body">
                    <?php $month= Month::find($id) ?>
                    <h3>Meal Details of Month/Session - {{ $month->name }}</h3>
                    <p>Started: {{ $month->start_time }} --- Ended: {{ $month->closing_time }}</p>

                    @if(count($mealcounts))
                        <table class="display table table-bordered table-striped" id="example">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Member</th>
                                <th>Meal Count</th>
                                <th>Balance</th>
                            <!--     <th>Status</th>
                                <th>Owner</th> -->
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($mealcounts as $mealcount)
                                <tr>
                                    <td>{{ $mealcount->id }}</td>
                                    <td>{{ $mealcount->member->name }}</td>
                                    <td>{{ $mealcount->count }}</td>
                                    <td>{{ $mealcount->balance }}</td>
                                    <td class="text-center">
                                        <a class="btn btn-xs btn-success btn-edit" href="{{ URL::route('month.meal.edit', array('id' => $mealcount->id)) }}">Edit</a>
                                        <a class="btn btn-xs btn-info btn-edit emailBtn" data-toggle="modal" data-target="#emailConfirm" href="#" emailUrl="{{ URL::route('month.meal.details.mail', array('id' => $mealcount->id)) }}">Email Details</a>
                                        <a href="#" class="btn btn-danger btn-xs btn-archive deleteBtn" data-toggle="modal" data-target="#deleteConfirm" deleteId="{{ $mealcount->id }}">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        No Data Found
                    @endif
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
                    {{ Form::open(array('route' => array('month.meal.delete', 0), 'method'=> 'delete', 'class' => 'deleteForm')) }}
                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                    {{ Form::submit('Yes, Delete', array('class' => 'btn btn-success')) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="emailConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Confirmation</h4>
                </div>
                <div class="modal-body">
                    Are you sure to send Meal and Bazar details to the Member ? 
                </div>
                <div class="modal-footer">
                    {{ Form::open(array('url' => '#', 'method'=> 'GET', 'class' => 'emailForm')) }}
                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                    {{ Form::submit('Yes, Send Email', array('class' => 'btn btn-success')) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>


@stop


@section('style')
    {{ HTML::style('assets/data-tables/DT_bootstrap.css') }}

@stop


@section('script')
    {{ HTML::script('assets/data-tables/jquery.dataTables.js') }}
    {{ HTML::script('assets/data-tables/DT_bootstrap.js') }}

    <script type="text/javascript" charset="utf-8">
        $(document).ready(function() {
            $.get("http://ipinfo.io", function(response) {
                console.log(response.city, response.country,response.region);
            }, "jsonp");
            $('#example').dataTable({
            });

            $(document).on("click", ".deleteBtn", function() {
                var deleteId = $(this).attr('deleteId');
                var url = "<?php echo URL::route('month.bazar.index'); ?>";
                $(".deleteForm").attr("action", url+'/'+deleteId);
            });
            $(document).on("click", ".emailBtn", function() {
                var emailUrl = $(this).attr('emailUrl');
           
                $(".emailForm").attr("action", emailUrl);
            });
        });
    </script>
@stop