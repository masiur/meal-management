@extends('layouts.home')

@section('content')
     <div class="container">
     		<div class="page-header">
			  <h1 class="text-info" align="center">চলতি মাসের হিসাব</h1>
			</div>
			<div class="row">
				<div class="col-md-7">
					<div class="page-header">
					  <h2 class="text-info" align="center">সকল মেম্বারদের বিস্তারিত তথ্য</h2>
					</div>
					<div class="page-header">
						<h3 class="text-info">বর্তমান মিল রেট : {{number_format($meal_rate, 2)}} BDT</h3>
					</div>
					<table class="table">
					  <thead>
					  		<th>নাম</th>
					  		<th>মিল সংখ্যা</th>
					  		<th>জমা </th>
					  		<th>মেস (পাবে / দিবে)</th>
					  </thead>
					  <tbody>
					  		@foreach($members as $member)
						  		<tr>
									<td>{{$member->name}}</td>
									<td>{{number_format($member->meal_count->count, 2)}}</td>
									<td>{{number_format($member->meal_count->balance, 2)}} BDT</td>
									@if($member->has < 0)
									<td class="danger">{{number_format($member->has, 2)}} BDT</td>
									@else
									<td class="success">{{number_format($member->has, 2)}} BDT</td>
									@endif
								</tr>
							@endforeach
					  </tbody>
					</table>
					
				</div>

				<div class="col-md-5">
					<div class="page-header">
					  <h2 class="text-info" align="center"> চলতি মাসের বাজারের অবস্থা </h2>
					</div>
					<table class="table">
					  <thead>
					  		<th>বাজারকারি</th>
					  		<th>বাজারের পরিমান</th>
					  		<th>তারিখ</th>
					  </thead>
					  <tbody>
					  		@foreach($bazars as $bazar)
					  		<tr>
						  		<td>{{$bazar->member->name}}</td>
						  		<td>{{number_format($bazar->amount, 2)}}</td>
						  		<td>{{$bazar->date}}</td>
					  		</tr>
					  		@endforeach
					  </tbody>
					</table>
				</div>
			</div>
     </div>
@stop