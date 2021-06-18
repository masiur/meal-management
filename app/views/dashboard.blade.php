@extends('layouts.default')
    @section('content')
        @include('includes.alert')
        <h2>Welcome to General Meal Mangement System</h2> Now, {{date('l jS \of F Y h:i:s A T')}}

        <h4>Last 5 Session Details of your flat, <b><i>{{ Auth::user()->flat_full_name }}</i></b></h4>
         <div class="panel-body">
                    @if(count($months))
                        <table class="display table table-bordered table-striped" id="example">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th>Session</th>
                                <th>Central Cost</th>
                                <th>Started</th>
                                <th>Closing Time</th>
                                <th>Notes</th>
                                <th>Last Update</th>
                                <th class="text-center">Links</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php $count=1 ?>
                            @foreach($months as $month)
                                <tr>
                                    <td> {{ $count++ }}</td>
                                    <td>
                                        <a class="btn btn-xs btn-default btn-show" href="{{ URL::route('user.month', array('month' => $month->name, 'user' => Auth::user()->flat_short_name )) }}">{{ $month->name }}</a>
                                        <a title="Go to Meal Details" class="btn btn-xs btn-primary btn-show" href="{{ URL::route('month.meal.index', array('id' => $month->id)) }}"> Meal Details</a>
                                    </td>
                                    <td>{{ $month->cost }}</td>
                                    <td>{{ $month->start_time }}</td>
                                    <td>{{ $month->closing_time }}</td>
                                    <td>{{ $month->notes }}</td>
                                    <td>{{ $month->updated_at->format('h:m:s a  d-m-Y') }}</td>
                                    <td class="text-center">
                                        <a class="btn btn-xs btn-primary btn-show" href="{{ URL::route('month.bazar.index', array('id' => $month->id)) }}">Bazars</a>
                                        <a class="btn btn-xs btn-info btn-show" href="{{ URL::route('month.meal.index', array('id' => $month->id)) }}">Meals</a>
                                        
                                        <a class="btn btn-xs btn-success btn-edit" href="{{ URL::route('month.edit', array('id' => $month->id)) }}">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        No Data Found
                    @endif
                </div>
@stop