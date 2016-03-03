@extends('layouts.home')

@section('content')
     <div class="container">
     		<div class="page-header">
			  <h1 class="text-info">চলতি মাসের হিসাব</h1>
			</div>
			<div class="row">
				<div class="col-md-7">
					<div class="page-header">
					  <h1 class="text-info">সকল মেম্বারদের বিস্তারিত তথ্য</h1>
					</div>
					<div>
						<h2>নাম : জয়</h2>
						<h2>সর্বমোট মিল সংখ্যা: 45</h2>
						<h2>জমা : জয়</h2>
						<h2>মেস : 116/=</h2>
					</div>
				</div>

				<div class="col-md-5">
					<div class="page-header">
					  <h1 class="text-info"> চলতি মাসের বাজারের অবস্থা </h1>
					</div>
					<table class="table">
					  <thead>
					  		<th>বাজারকারি</th>
					  		<th>বাজারের পরিমান</th>
					  		<th>তারিখ</th>
					  </thead>
					  <tbody>
					  		<td>বাজারকারি</td>
					  		<td>বাজারের পরিমান</td>
					  		<td>তারিখ</td>
					  </tbody>
					</table>
				</div>
			</div>
     </div>
@stop