@extends('layouts.default')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            @include('includes.alert')
            <section class="panel">
                <header class="panel-heading clearfix">
                    {{ $title }}
                    <span class="pull-right">

                            <a class="btn btn-success btn-sm btn-new-user" href="{{ URL::route('month.bazar.create', ['id' => $id]) }}">Create New Bazar</a>

                    </span>
                </header>
                <div class="panel-body">
                    @if(count($bazars))
                        <table class="display table table-bordered table-striped" id="example">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th>Amount</th>
                                <th>Details</th>
                                <th>Date</th>
                                <th>Who ?</th>
                            <!--     <th>Status</th>
                                <th>Owner</th> -->
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php $count=1 ?>
                            @foreach($bazars as $bazar)
                                <tr>
                                    <td> {{ $count++ }}</td>
                                    <td>{{ $bazar->amount }}</td>
                                    <td>@if(!is_null(json_decode($bazar->details)))
                                         
                                            {{ json_decode($bazar->details)  }}
                                        @else
                                            {{ $bazar->details }}
                                        @endif
                                        
                                    </td>
                                    <td>{{ $bazar->date }}</td>
                                    <td>{{ $bazar->member->name }}</td>
                                    <td class="text-center">
                                        <a class="btn btn-xs btn-success btn-edit" href="{{ URL::route('month.bazar.edit', array('id' => $bazar->id)) }}">Edit</a>
                                        <a href="#" class="btn btn-danger btn-xs btn-archive deleteBtn" data-toggle="modal" data-target="#deleteConfirm" deleteUrl="{{ URL::route('month.bazar.delete', $bazar->id) }}">Delete</a>
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
                    {{ Form::open(array('route' => array('month.bazar.delete', 0), 'method'=> 'POST', 'class' => 'deleteForm')) }}
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
                var deleteUrl = $(this).attr('deleteUrl');
                $(".deleteForm").attr("action", deleteUrl);
            });
        });
    </script>
@stop