<aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">

                <!-- dashboard -->

                  <li>

                      <a href="{{ URL::route('dashboard') }}">
                          <i class="fa fa-dashboard"></i>
                          <span>Dashboard</span>
                      </a>
                  </li>
                  <li>
                      <a href="{{ URL::route('user.month', ['user' => Auth::user()->flat_short_name] ) }}" target="_blank">
                          <i class="fa fa-home"></i>
                          <span>Public Page</span>
                      </a>
                  </li>

                  {{-- Member --}}

                  <li>

                      <a href="{{ route('member.index') }}">
                          <i class="fa fa-tasks"></i>
                          <span>Members</span>
                      </a>
                      {{--<ul class="sub"> --}}
                        {{--<li><a href="{{ route('member.index') }}">All Members</a></li>  --}}
                        {{--<li><a href="{{ route('member.create') }}">Create a Member</a></li>--}}
                        {{----}}
                      {{--</ul>--}}

                  </li> 

                  {{-- Month --}}

                  <li >

                      <a href="{{ route('month.index') }}">
                          <i class="fa fa-tasks"></i>
                          <span>Months</span>
                      </a>
                      {{--<ul class="sub"> --}}
                        {{--<li><a href="{{ route('month.index') }}">All Months</a></li>  --}}
                        {{--<li><a href="{{ route('month.create') }}">Create a Month</a></li>--}}
                        {{----}}
                      {{--</ul>--}}

                  </li> 
                  

                  {{-- Roles & Permissions --}}

                  @if(Auth::user()->hasRole('admin'))
                  <li >

                      <a href="#">
                          <i class="fa fa-tasks"></i>
                          <span>Global Admin Section</span>
                      </a>
                      <ul class="sub"> 
                        <li><a href="{{ route('user.index') }}">All Flats</a></li> 
                        <li><a href="{{ route('user.create') }}">Add a Flat</a></li>
                      
                      </ul>

                  </li> 
                  @endif


                  









              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>