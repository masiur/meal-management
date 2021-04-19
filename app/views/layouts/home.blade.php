<!DOCTYPE html>
<html lang="en">
@include('includes.header')
<body>
	
	@yield('content')

	{{ HTML::script('js/jquery.js') }}
  	{{ HTML::script('js/bootstrap.min.js') }}

  	<!-- {{ HTML::script('js/custom.js') }} -->
	@yield('script')
</body>
</html>


