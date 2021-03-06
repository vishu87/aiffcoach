<div class="page-sidebar navbar-collapse collapse">
  <ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
    <li class="sidebar-toggler-wrapper">
      <div class="sidebar-toggler">
      </div>
    </li>
    <li style="height:10px">
    </li>
    <li class="@if($sidebar == 'dashboard' ) active @endif" >
      <a href="{{url('/admin')}}">
        <i class="fa fa-home"></i>
        <span class="title">Dashboard</span>
        <span class="selected"></span>
      </a>
    </li>
    <li class="@if($sidebar == 'coach' ) active open @endif">
      <a href="javascript:;">
      <i class="fa fa-users"></i>
      <span class="title">Registrations</span>
      <span class="arrow @if($sidebar == 'coach' ) open @endif"></span>
      </a>
      <ul class="sub-menu">
        <li class="@if($sidebar == 'coach' && $subsidebar == 1 ) active @endif" style="display:inherit">
          <a href="{{url('admin/approvedCoach')}}">
          <i class="fa fa-chevron-right"></i>
          Coaches Approved</a>
        </li>
        <li class="@if($sidebar == 'coach' && $subsidebar == 2 ) active @endif">
          <a href="{{url('admin/pendingCoach')}}">
          <i class="fa fa-chevron-right"></i>
          Coaches Under Process</a>
        </li>

        <li class="@if($sidebar == 'coach' && $subsidebar == 3 ) active @endif">
          <a href="{{url('pendingApprovals/pendingDocument')}}">
          <i class="fa fa-chevron-right"></i>
          Under Approval Details</a>
        </li>

      </ul>
    </li>
    
    <li class="@if($sidebar == 'license' ) active @endif" >
      <a href="{{url('/admin/License')}}">
        <i class="fa fa-key"></i>
        <span class="title">Licenses</span>
        <span class="selected"></span>
      </a>
    </li>

    <li class="@if($sidebar == 'coach-employments' ) active @endif" >
      <a href="{{url('/admin/coach-employments')}}">
        <i class="fa fa-cube"></i>
        <span class="title">Coach Employments</span>
        <span class="selected"></span>
      </a>
    </li>

    <li class="@if($sidebar == 2 ) active @endif" >
      <a href="{{url('/admin/Parameter')}}">
        <i class="fa fa-lock"></i>
        <span class="title">Parameters</span>
        <span class="selected"></span>
      </a>
    </li>
    <li class="@if($sidebar == 3 ) active @endif" >
      <a href="{{url('/admin/coursesParameter')}}">
        <i class="fa fa-lock"></i>
        <span class="title">License Parameter</span>
        <span class="selected"></span>
      </a>
    </li>
    <li class="@if($sidebar == 'courses' ) active open @endif">
      <a href="javascript:;">
      <i class="fa fa-book"></i>
      <span class="title">Courses</span>
      <span class="arrow @if($sidebar == 'courses' ) open @endif"></span>
      </a>
      <ul class="sub-menu">
        <li class="@if($sidebar == 'courses' && $subsidebar == 4 ) active @endif">
          <a href="{{url('admin/Courses/add')}}">
          <i class="fa fa-chevron-right"></i>
          Add Course</a>
        </li>
        <li class="@if($sidebar == 'courses' && $subsidebar == 2 ) active @endif">
          <a href="{{url('admin/Courses/active')}}">
          <i class="fa fa-chevron-right"></i>
          Active</a>
        </li>
        <li class="@if($sidebar == 'courses' && $subsidebar == 3 ) active @endif">
          <a href="{{url('admin/Courses/upcoming')}}">
          <i class="fa fa-chevron-right"></i>
          Upcoming</a>
        </li>
        <li class="@if($sidebar == 'courses' && $subsidebar == 1 ) active @endif" style="display:inherit">
          <a href="{{url('admin/Courses')}}">
          <i class="fa fa-chevron-right"></i>
          All</a>
        </li>
      </ul>
    </li>
    <li class="@if($sidebar == 'Applications' ) active open @endif">
      <a href="javascript:;">
      <i class="fa fa-edit"></i>
      <span class="title">Applications</span>
      <span class="arrow @if($sidebar == 'Applications' ) open @endif"></span>
      </a>
      <ul class="sub-menu">
        <li class="@if($sidebar == 'Applications' && $subsidebar == 2 ) active @endif">
          <a href="{{url('admin/Applications/all')}}">
          <i class="fa fa-chevron-right"></i>
          All Applications</a>
        </li>
      </ul>
    </li>
    <li class="@if($sidebar == 'results' ) active @endif" >
      <a href="{{url('/admin/ApplicationResults')}}">
        <i class="fa fa-key"></i>
        <span class="title">Results</span>
        <span class="selected"></span>
      </a>
    </li>
    <li class="@if($sidebar == 'payment' ) active @endif" >
      <a href="{{url('/admin/Payment')}}">
        <i class="fa fa-credit-card"></i>
        <span class="title">Payments</span>
        <span class="selected"></span>
      </a>
    </li>
    <li class="@if($sidebar == 'logins' ) active @endif" >
      <a href="{{url('/admin/logins')}}">
        <i class="fa fa-users"></i>
        <span class="title">Manage Logins</span>
        <span class="selected"></span>
      </a>
    </li>

    <li class="@if($sidebar == 'profile' ) active @endif" >
      <a href="{{url('/changePassword')}}">
        <i class="fa fa-lock"></i>
        <span class="title">Change Password</span>
        <span class="selected"></span>
      </a>
    </li>
  </ul>
</div>