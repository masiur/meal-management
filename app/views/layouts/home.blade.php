<!DOCTYPE html>
<html lang="en">
@include('includes.header')
<body>
	
	@yield('content')

	{{ HTML::script('js/jquery.js') }}
  	{{ HTML::script('js/bootstrap.min.js') }}
  	{{ HTML::script('js/jquery.dcjqaccordion.2.7.js', array('class' => 'include')) }}
  	{{ HTML::script('js/jquery.scrollTo.min.js') }}
  	{{ HTML::script('js/jquery.nicescroll.js') }}
  	{{ HTML::script('js/respond.min.js') }}
    {{ HTML::script('js/slidebars.min.js') }}
  	{{ HTML::script('js/common-scripts.js') }}
  	
  	{{ HTML::script('js/custom.js') }}
	@yield('script')
</body>
</html>


