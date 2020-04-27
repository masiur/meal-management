    <!--footer start-->
    <footer class="site-footer">
          <div class="text-center">
              Copyright ©2016 - {{ Date('Y') }} <a target="_blank" href="https://www.linkedin.com/in/md-nayeem-iqubal/">Joy</a> & <a target="_blank" href="https://www.linkedin.com/in/masiurcse/">Masiur</a>

              <a href="#" class="go-top">
                  <i class="fa fa-angle-up"></i>
              </a>
          </div>
      </footer>
    <!--footer end-->

</section>

  	{{ HTML::script('js/jquery.js') }}
  	{{ HTML::script('js/bootstrap.min.js') }}
  	{{ HTML::script('js/jquery.dcjqaccordion.2.7.js', array('class' => 'include')) }}
  	{{ HTML::script('js/jquery.scrollTo.min.js') }}
  	{{ HTML::script('js/jquery.nicescroll.js') }}
  	{{ HTML::script('js/respond.min.js') }}
    {{ HTML::script('js/slidebars.min.js') }}
  	{{ HTML::script('js/common-scripts.js') }}
  	@yield('script')
  	{{ HTML::script('js/custom.js') }}

    

