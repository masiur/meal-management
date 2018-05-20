@extends('layouts.home')

@section('content')
     <div class="container">
     		<div class="page-header">
			  <h1 class="text-info" align="center">চলতি মাসের হিসাব ( {{ $month->name }} )</h1>
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
					<div class="page-header">
					  <h2 class="text-info" align="center"> চলতি মাসের বাজারের অবস্থা </h2>
						<h4 class="text-info">মেস বাজার : {{ $monthCost }} BDT</h4>
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

				<div class="col-md-5">
					<div class="page-header">
					  <h2 class="text-info" align="center">অভিযোগ / মন্তব্য</h2>
					</div>
					<!-- <div class="container"> -->
						<div class="post-form">
							<form>
							  <div class="form-group">
							    <!-- <label for="exampleInputEmail1">Email address</label> -->
							    <input type="text" id="name" class="form-control" placeholder="কে আপনি ?">
							  </div>
							  <div class="form-group">
							    <!-- <label for="exampleInputEmail1">Email address</label> -->
							    <textarea id="post" class="form-control" placeholder="কিছু বলবেন ?"></textarea>
							  </div>
							  <button type="submit" class="btn btn-default">পেশ করুন</button>
							</form>
						</div>
						<div id="posts">
							<?php $posts = Post::orderBy('id', 'desc')->get(); ?>
							@foreach($posts as $post)
							<div class="post">
								<h2 class="text-center">{{nl2br(e($post->owner))}} , বলেছেন</h2>
								<p>{{nl2br(e($post->post))}}</p>
							</div>
							@endforeach
						</div>
						
					<!-- </div> -->
				</div>
			</div>
     </div>

@stop

@section('script')
	<script type="text/javascript">
		var baseUrl = '{{asset('/')}}';
		$(document).ready(function() {
            
            $('form').submit(function(){
            	var owner = $(this).find('#name');
            	var post = $(this).find('#post');
            	// alert(post);
            	$.ajax({
	            	type: "POST",
	      			url: baseUrl + "/post/store",
	      			data: {
	      				owner : owner.val(),
	     				post : post.val()
	      			},
	      			dataType  : 'json',
				     success: function(response){
				       	if(response.message == "success"){
				       		owner.val('');
				       		post.val('');
				       		var postHeader = $('<h2/>', {class: 'text-center'});
				       		postHeader.append(response.post.owner + ", বলেছেন");
			            	 // console.log(postHeader);
			            	var postParagraph = $('<p/>');
			            	postParagraph.append(response.post.post);
			            	var postDiv = $('<div/>', {text: "", class: 'post'});
			            	postDiv.append(postHeader);
			            	postDiv.append(postParagraph);
			            	console.log(postDiv);
			            	$('#posts').prepend(postDiv);
				       	}
				      },
				      error: function(){
				         console.log('Error');
				      }
				  });	

            	return false;
            });

            
          
        });
	</script>
@stop