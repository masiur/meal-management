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

                  {{-- Member --}}

                  <li class="sub-menu">

                      <a href="javascript:;">
                          <i class="fa fa-tasks"></i>
                          <span>Member</span>
                      </a>
                      <ul class="sub"> 
                        <li><a href="{{ route('member.index') }}">All Members</a></li>  
                        <li><a href="{{ route('member.create') }}">Create a Member</a></li>
                        
                      </ul>

                  </li> 

                  {{-- Month --}}

                  <li class="sub-menu">

                      <a href="javascript:;">
                          <i class="fa fa-tasks"></i>
                          <span>Month</span>
                      </a>
                      <ul class="sub"> 
                        <li><a href="{{ route('month.index') }}">All Months</a></li>  
                        <li><a href="{{ route('month.create') }}">Create a Month</a></li>
                        
                      </ul>

                  </li> 
                  

                  {{-- Roles & Permissions --}}
                  <li>

                      <a href="#">
                          <i class="fa fa-gears"></i>
                          <span>Roles & Permissions</span>
                      </a>
                  </li>


                  









              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>