<div class="page-sidebar navbar-collapse collapse">
  <ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
    <li class="sidebar-toggler-wrapper">
      <div class="sidebar-toggler">
      </div>
    </li>
    <li style="height:10px">
    </li>
    <li class="@if($sidebar == 'dashboard' ) active @endif" >
      <a href="{{url('/superAdmin/dashboard')}}">
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
        <li class="@if($sidebar == 'coach' && $subsidebar == 1 ) active @endif" style="display:inherit">
          <a href="{{url('admin/approvedCoach')}}">
          <i class="fa fa-chevron-right"></i>
          Approved</a>
        </li>
         <li class="@if($sidebar == 'coach' && $subsidebar == 2 ) active @endif">
          <a href="{{url('admin/pendingCoach')}}">
          <i class="fa fa-chevron-right"></i>
          Under Process</a>
        </li>
      </ul>
    </li>
    <li class="@if($sidebar == 2 ) active @endif" >
      <a href="{{url('/superAdmin/manage_logins')}}">
        <i class="fa fa-users"></i>
        <span class="title">Manage Logins</span>
        <span class="selected"></span>
      </a>
    </li>
  </ul>
</div>


