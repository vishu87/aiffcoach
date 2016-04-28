<div class="page-sidebar navbar-collapse collapse">
  <ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
    <li class="sidebar-toggler-wrapper">
      <div class="sidebar-toggler">
      </div>
    </li>
    <li style="height:10px">
    </li>
    <li class="@if($sidebar == 'profile' ) active @endif" >
      <a href="{{url('/coach')}}">
        <i class="fa fa-user"></i>
        <span class="title">Profile</span>
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
    <li class="@if($sidebar == 3 ) active @endif" >
      <a href="{{url('/coach/activity')}}">
        <i class="fa fa-cube"></i>
        <span class="title">Activities</span>
        <span class="selected"></span>
      </a>
    </li>
  </ul>
</div>