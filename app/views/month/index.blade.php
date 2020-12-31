@extends('layouts.default')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            @include('includes.alert')
            <section class="panel">
                <header class="panel-heading clearfix">
                    {{ $title }}
                    <span class="pull-right">

                            <a class="btn btn-success btn-sm btn-new-user" href="{{ URL::route('month.create') }}">Create New Month/Session</a>

                    </span>
                </header>
                <div class="panel-body">
                    @if(count($months))
                        <table class="display table table-bordered table-striped" id="example">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th>Session</th>
                                <th>Mess Cost</th>
                                <th>Started</th>
                                <th>Ended</th>
                                <th>Notes</th>
                                <th>Status</th>
                                <th>Meal Rate</th>
                                <th>Last Update</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php $count=1 ?>
                            @foreach($months as $month)
                                <tr>
                                    <td> {{ $count++ }}</td>
                                    <td>
                                        <a class="btn btn-xs btn-success btn-show" href="{{ URL::route('user.month', array('month' => $month->name, 'user' => Auth::user()->flat_short_name )) }}">{{ $month->name }}</a>
                                    </td>
                                    <td>{{ $month->cost }}</td>
                                    <td>{{ $month->start_time }}</td>
                                    <td>{{ $month->closing_time }}</td>
                                    <td>{{ $month->notes }}</td>
                                    <td>{{ $month->status }}</td>
                                    <td>{{ $month->meal_rate }}</td>
                                    <td>{{ $month->updated_at->format('h:i:s a  d-m-Y') }}</td>
                                    <td class="text-center">
                                        <a class="btn btn-xs btn-success btn-show" href="{{ URL::route('month.bazar.index', array('id' => $month->id)) }}">Bazars</a>
                                        <a class="btn btn-xs btn-info btn-show" href="{{ URL::route('month.meal.index', array('id' => $month->id)) }}">Meals</a>
                                        
                                        <a class="btn btn-xs btn-success btn-edit" href="{{ URL::route('month.edit', array('id' => $month->id)) }}">Edit</a> <br>

                                        <a class="btn btn-xs btn-primary btn-edit" href="{{ URL::route('month.meal.rate', array('id' => $month->id)) }}">Cal/Re-Calculate Meal Rate</a>
                                        <a href="#" class="btn btn-danger btn-xs btn-archive deleteBtn" data-toggle="modal" data-target="#deleteConfirm" deleteId="{{ $month->id }}">Delete</a>
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
                    {{ Form::open(array('route' => array('month.delete', 0), 'method'=> 'delete', 'class' => 'deleteForm')) }}
                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                    {{ Form::submit('Yes, Delete', array('class' => 'btn btn-success')) }}
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
                var url = "<?php echo URL::route('month.index'); ?>";
                $(".deleteForm").attr("action", url+'/'+deleteId);
            });
        });
    </script>
@stop