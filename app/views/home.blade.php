@extends('layouts.home')

@section('content')
	<div class="container">
		<div class="page-header">
			<h1 class="text-info" align="center">( {{ $month->name }} ) সেশনের হিসাব </h1>
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
					<th>বাজার + অন্যান্য = মোট জমা</th>
					<th>মেস (পাবে/দিবে)</th>
					</thead>
					<tbody>
					<?php $plus_minus_balancing = 0; ?>
					@foreach($mealDetailsAllMembers as $mealDetailsPerMember)
						<tr>
							<td>{{ $mealDetailsPerMember->member->name }}</td>
							<td>{{number_format($mealDetailsPerMember->count, 2)}}</td>
							<td>
								{{number_format($mealDetailsPerMember->total_bazar_per_head, 0)}} +
								{{number_format($mealDetailsPerMember->balance, 0)}} =
								{{ $mealDetailsPerMember->total_bazar_per_head + $mealDetailsPerMember->balance }}
								BDT
							</td>
							@if($mealDetailsPerMember->balancePlusOrMinusToBeGiven < 0)
								<td class="danger">{{number_format($mealDetailsPerMember->balancePlusOrMinusToBeGiven, 2)}} BDT</td>
							@else
								<td class="success">{{number_format($mealDetailsPerMember->balancePlusOrMinusToBeGiven, 2)}} BDT</td>
							@endif
						</tr>
					<?php $plus_minus_balancing += $mealDetailsPerMember->balancePlusOrMinusToBeGiven; ?>
					@endforeach
					<tfoot>
						<tr>
							<th>মোট  </th>
							<th> = {{ $total_meal_this_month }}</th>
							<th> = {{ $total_bazar_this_month }} BDT</th>
							<th> {{ number_format($plus_minus_balancing, 2) }} </th>
						</tr>
					</tfoot>
					</tbody>
				</table>
				<div class="page-header">
					<h2 class="text-info" align="center"> চলতি মাসের বাজারের অবস্থা </h2>
					<h4 class="text-info">মেস খরচ : {{ $monthCost }} BDT</h4>
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
							<td>{{number_format($bazar->amount, 2)}}
								<?php 
									if(!is_null(json_decode($bazar->details))){
										$details = json_decode($bazar->details);
									}else {
										$details = $bazar->details;
									}
                                 ?>
								<button type="button" class="btn btn-secondary btn-xs example-popover" data-container="body" data-toggle="popover" data-placement="right"  data-content="{{ $details }}">
									Details
								</button>
							</td>
							<td>{{$bazar->date}}</td>
						</tr>
					@endforeach
					</tbody>
				</table>

			</div>

			<div class="col-md-5 no-print">
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
                    <?php $posts = $month->posts; ?>
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

	<footer class="text-center"><i class="fa fa-heart"></i> Powered By <a target="_blank" href="https://www.MasiurSiddiki.com">www.MasiurSiddiki.com</a>  ---!---  Copyright ©2016 - {{ Date('Y') }} <a target="_blank" href="https://www.MasiurSiddiki.com/">Masiur</a> & <a target="_blank" href="https://www.linkedin.com/in/md-nayeem-iqubal/">Joy</a> </footer>

@stop

@section('script')
	<script type="text/javascript">
        $(function () {
            $('.example-popover').popover({
                container: 'body'
            })
        });
        console.log({{ $mealDetailsAllMembers }});
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
                        post : post.val(),
                        month_id : '{{ $month->id }}'
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