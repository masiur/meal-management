@extends('layouts.default')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            @include('includes.alert')
            <section class="panel">
                <header class="panel-heading clearfix">
                    {{ $title }}
                    <span class="pull-right">

                            <a class="btn btn-info btn-sm btn-new-user" href="{{ URL::route('month.bazar.index', ['id' => $id]) }}">Bazar of This Session</a>
                            <a class="btn btn-success btn-sm btn-new-user" href="{{ URL::route('month.meal.create', ['id' => $id]) }}">Create New Entry</a>

                    </span>
                </header>

                <div class="panel-body" style="overflow-x: scroll!important;">
                    <?php $month= Month::find($id) ?>
                    <h3>Meal Details of Month/Session - <strong>{{ $month->name }}</strong></h3>
                    <p>Started: {{ $month->start_time }} --- Ended: {{ $month->closing_time }}</p>

                    @if(count($mealcounts))
                        <table class="display table table-bordered table-striped" id="example">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th>Member</th>
                                <th>Meal Count</th>
                                <th>Balance</th>
                                <th>Notes</th>
                                <th>Status</th>
                                <th>Last Update</th> 
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php $count=1 ?>
                            @foreach($mealcounts as $mealcount)
                                <tr>
                                    <td> {{ $count++ }}</td>
                                    <td>{{ $mealcount->member->name }} </td>
                                    <td ><span class="updatedNewMeal">{{ $mealcount->count }}</span>
                                        <a class="btn btn-xs btn-success btn-edit meal-update-btn" mealId="{{ $mealcount->id }}" href="{{ URL::route('month.meal.increment', array('id' => $mealcount->id, 'count' => 1, 'month_id' => $mealcount->month_id)) }}">+1</a>
                                        <a class="btn btn-xs btn-danger btn-edit meal-update-btn" href="{{ URL::route('month.meal.increment', array('id' => $mealcount->id, 'count' => -1, 'month_id' => $mealcount->month_id)) }}">-1</a>
                                        <a class="btn btn-xs btn-info btn-edit meal-update-btn" href="{{ URL::route('month.meal.increment', array('id' => $mealcount->id, 'count' => 2, 'month_id' => $mealcount->month_id)) }}">+2</a>
                                        <a class="btn btn-xs btn-warning btn-edit meal-update-btn" href="{{ URL::route('month.meal.increment', array('id' => $mealcount->id, 'count' => 5, 'month_id' => $mealcount->month_id)) }}">+5</a>
                                    </td>
                                    
                                    <td>{{ $mealcount->balance }}</td>
                                    <td>{{ $mealcount->notes }}</td>
                                    <td>{{ $mealcount->status }}</td>
                                    <td>{{ $mealcount->updated_at->format('D, M j, Y h:i:s A T') }}</td>
                                    <td class="text-center">
                                        <a class="btn btn-xs btn-success btn-edit" href="{{ URL::route('month.meal.edit', array('id' => $mealcount->id)) }}">Edit</a>
                                        <a class="btn btn-xs btn-info btn-edit emailBtn"  href="{{ URL::route('bill.index', array('member' => $mealcount->member_id, 'month' => $mealcount->month_id)) }}">View Details</a>

                                        <a title="Send Email to Member About Current Meal & Bazar Update" class="btn btn-xs btn-primary btn-edit emailBtn" data-toggle="modal" data-target="#emailConfirm" href="#" emailUrl="{{ URL::route('month.meal.details.mail', array('id' => $mealcount->id)) }}">Email Current Update</a>
                                        
                                        @if($month->status == 'COMPLETED')
                                        <a class="btn btn-xs btn-warning btn-edit emailBtn"  href="{{ URL::route('month.meal.invoice.mail', array('id' => $mealcount->id)) }}">Email Invoice</a>
                                        @endif
                                        <!-- <a href="#" class="btn btn-danger btn-xs btn-archive deleteBtn" data-toggle="modal" data-target="#deleteConfirm" deleteId="{{ $mealcount->id }}">Delete</a> -->
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {{ $mealcounts->links() }} 
                    @else
                        No Data Found
                    @endif
                </div>

                <div class="panel-body col-md-12">
                    SMS To all
                    <div class="row">
                        <div class="col-md-6">
                            <?php
                                $count=1;
                                $toBeSMSedArray = [];

                            ?>
                            <ol>
                                @foreach($mealcounts as $mealcount)
                                    <?php $count++;

                                        $toBeSMSedArray[] = $mealcount->member_id;
                                    ?>

                                    <li>{{ $mealcount->member->name }} - {{ $mealcount->member->mobile }} - {{ $mealcount->member->email }}</li>
                                @endforeach
                            </ol>
                        </div>
                        <?php $recipients = base64_encode(serialize($toBeSMSedArray)); ?>
                        <div class="col-md-6">
                            <form method="POST" action="{{ route('send.bulk.sms', ['month_id' => $id]) }}">
                                <p>Dear $name</p>
                                <textarea class="form-control"  name="sms_text" rows="8" cols="50" maxlength="320" placeholder="Enter SMS text... upto 320 chars"></textarea>
                                <p>C1 Meal System.</p>
                                <input type="hidden" value="{{ $recipients }}" name="recipients">
                                <div class="col-lg-4">
                                    <input class="btn btn-primary" type="submit" value="Send SMS to All">
                                </div>
                            </form>


                        </div>
                    </div>
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
                    {{ Form::submit('Yes, Send Email', array('class' => 'btn btn-info')) }}
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
           
            // $('#example').dataTable({
            //     "pageLength": 50
            // });
            // function changeHtml(response) {
            //     $("#flashmessage").text('lkdfkd');
            // }
            $(document).on("click", ".meal-update-btn", function(e) {
                e.preventDefault();
                let mealCountElementTD = $(this).parent();
                let mealUpdateUrl = $(this).attr('href');

                console.log(mealUpdateUrl);
                $.ajax({
                    type: "GET",
                    url: mealUpdateUrl,
                    success: function (response) {
                        console.log(response);
                        // console.log(elem);

                        // console.log(pp);
                        mealCountElementTD.children("span.updatedNewMeal").text(response.new_meal);
                        // $('#success').html(`<span style="color:green">kfdjfkdjfk</span>`);
                        // changeHtml(response);

                    },
                    error: function (response) {
                        console.log(response);
                        // $("span#success").html(`<span style="color:darkred">${response.message}</span>`);
                    }

                })
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