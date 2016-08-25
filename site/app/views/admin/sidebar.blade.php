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
      <span class="title">Officials</span>
      <span class="arrow @if($sidebar == 'coach' ) open @endif"></span>
      </a>
      <ul class="sub-menu">
        <!-- <li class="@if($sidebar == 'coach' && $subsidebar == 1 ) active @endif" style="display:inherit">
          <a href="{{url('admin/approvedCoach')}}">
          <i class="fa fa-chevron-right"></i>
          Approved</a>
        </li> -->
        
         <li class="@if($sidebar == 'coach' && $subsidebar == 2 ) active @endif">
          <a href="{{url('admin/pendingCoach')}}">
          <i class="fa fa-chevron-right"></i>
          Pending</a>
        </li>

        <li class="@if($sidebar == 'coach' && $subsidebar == 3 ) active @endif">
          <a href="{{url('admin/all')}}">
          <i class="fa fa-chevron-right"></i>
          All </a>
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
    <li class="@if($sidebar == 'courses' ) active open @endif">
      <a href="javascript:;">
      <i class="fa fa-book"></i>
      <span class="title">Courses</span>
      <span class="arrow @if($sidebar == 'courses' ) open @endif"></span>
      </a>
      <ul class="sub-menu">

         <li class="@if($sidebar == 'courses' && $subsidebar == 2 ) active @endif">
          <a href="{{url('admin/Courses/active')}}">
          <i class="fa fa-chevron-right"></i>
          Active</a>
        </li>

        <!-- <li class="@if($sidebar == 'courses' && $subsidebar == 3 ) active @endif">
          <a href="{{url('admin/Courses/inactive')}}">
          <i class="fa fa-group"></i>
          Inactive</a>
        </li> -->

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
          <a href="{{url('admin/Applications/approved')}}">
          <i class="fa fa-chevron-right"></i>
          Approved</a>
        </li>

        <li class="@if($sidebar == 'Applications' && $subsidebar == 3 ) active @endif">
          <a href="{{url('admin/Applications/pending')}}">
          <i class="fa fa-chevron-right"></i>
          Pending</a>
        </li>
      </ul>
    </li>
    
    <li class="@if($sidebar == 'payment' ) active open @endif">
      <a href="javascript:;">
      <i class="fa fa-credit-card"></i>
      <span class="title">Payment</span>
      <span class="arrow @if($sidebar == 'payment' ) open @endif"></span>
      </a>
      <ul class="sub-menu">
        <li class="@if($sidebar == 'payment' && $subsidebar == 1 ) active @endif">
          <a href="{{url('admin/Payment')}}">
          <i class="fa fa-chevron-right"></i>
          All</a>
        </li>

        <li class="@if($sidebar == 'payment' && $subsidebar == 2 ) active @endif">
          <a href="{{url('admin/Payment/pending')}}">
          <i class="fa fa-chevron-right"></i>
          Pending</a>
        </li>
      </ul>
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


