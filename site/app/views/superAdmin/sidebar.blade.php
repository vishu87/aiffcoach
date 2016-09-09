<div class="page-sidebar navbar-collapse collapse">
  <ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
    <li class="sidebar-toggler-wrapper">
      <div class="sidebar-toggler">
      </div>
    </li>
    <li style="height:10px">
    </li>
    <li class="@if($sidebar == 1 ) active @endif" >
      <a href="{{url('/superAdmin/dashboard')}}">
        <i class="fa fa-home"></i>
        <span class="title">Dashboard</span>
        <span class="selected"></span>
      </a>
    </li>
    <li class="@if($sidebar == 2 ) active @endif" >
      <a href="{{url('/superAdmin/manage_logins')}}">
        <i class="fa fa-users"></i>
        <span class="title">Manage Logins</span>
        <span class="selected"></span>
      </a>
    </li>
    <li class="@if($sidebar == 3) active @endif" >
      <a href="{{url('/changePassword')}}">
        <i class="fa fa-lock"></i>
        <span class="title">Change Password</span>
        <span class="selected"></span>
      </a>
    </li>
  </ul>
</div>


