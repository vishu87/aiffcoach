<div class="page-sidebar navbar-collapse collapse">
  <ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
    <li class="sidebar-toggler-wrapper">
      <div class="sidebar-toggler">
      </div>
    </li>
    <li style="height:10px">
    </li>
    <li class="@if($sidebar == 'dashboard' ) active @endif" >
      <a href="{{url('/coach/dashboard')}}">
        <i class="fa fa-home"></i>
        <span class="title">Dashboard</span>
        <span class="selected"></span>
      </a>
    </li>
    <li class="@if($sidebar == 'profile' ) active @endif" >
      <a href="{{url('/coach/personalInformation')}}">
        <i class="fa fa-user"></i>
        <span class="title">My Profile</span>
        <span class="selected"></span>
      </a>
    </li>
    <li class="@if($sidebar == 2 ) active @endif" >
      <a href="{{url('/coach/employmentDetails')}}">
        <i class="fa fa-bars"></i>
        <span class="title">Employment Details</span>
        <span class="selected"></span>
      </a>
    </li>
    <li class="@if($sidebar == 3 ) active @endif hidden" >
      <a href="{{url('/coach/activity')}}">
        <i class="fa fa-tasks"></i>
        <span class="title">Activities</span>
        <span class="selected"></span>
      </a>
    </li>
    <li class="@if($sidebar == 5 ) active open @endif">
      <a href="javascript:;">
      <i class="fa fa-book"></i>
      <span class="title">Courses</span>
      <span class="arrow @if($sidebar == 5 ) open @endif"></span>
      </a>
      <ul class="sub-menu">
      
        <li class="@if($sidebar == 5 && $subsidebar == 1 ) active @endif">
          <a href="{{url('coach/courses/active')}}">
          <i class="fa fa-chevron-right"></i>
          Active</a>
        </li>

        <li class="@if($sidebar == 5 && $subsidebar == 3 ) active @endif">
          <a href="{{url('coach/courses/upcoming')}}">
          <i class="fa fa-chevron-right"></i>
          Upcoming</a>
        </li>

        <li class="@if($sidebar == 5 && $subsidebar == 2 ) active @endif">
          <a href="{{url('coach/courses/inactive')}}">
          <i class="fa fa-chevron-right"></i>
          Past</a>
        </li>
      </ul>
    </li>
    <li class="@if($sidebar == 4 ) active open @endif">
      <a href="javascript:;">
      <i class="fa fa-edit"></i>
      <span class="title">Applications</span>
      <span class="arrow @if($sidebar == 4 ) open @endif"></span>
      </a>
      <ul class="sub-menu">
        <li class="@if($sidebar == 4 && $subsidebar == 1 ) active @endif" style="display:inherit">
          <a href="{{url('coach/applications/applied')}}">
          <i class="fa fa-chevron-right"></i>
          My Applications</a>
        </li>
        
        <!-- <li class="@if($sidebar == 4 && $subsidebar == 2 ) active @endif">
          <a href="{{url('coach/applications/active')}}">
          <i class="fa fa-database"></i>
          Active</a>
        </li>

        <li class="@if($sidebar == 4 && $subsidebar == 3 ) active @endif">
          <a href="{{url('coach/applications/inactive')}}">
          <i class="fa fa-group"></i>
          Inactive</a> -->
        </li>
      </ul>
    </li>
    <li class="@if($sidebar == 6 ) active @endif" >
      <a href="{{url('/changePassword')}}">
        <i class="fa fa-lock"></i>
        <span class="title">Change Password</span>
        <span class="selected"></span>
      </a>
    </li>
  </ul>
</div>