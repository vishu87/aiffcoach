<div class="page-sidebar navbar-collapse collapse">
  <ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
    <li class="sidebar-toggler-wrapper">
      <div class="sidebar-toggler">
      </div>
    </li>
    <li style="height:10px">
    </li>
    <li class="@if($sidebar == 11 ) active @endif" >
      <a href="{{url('/resultAdmin/dashboard')}}">
        <i class="fa fa-home"></i>
        <span class="title">Dashboard</span>
        <span class="selected"></span>
      </a>
    </li>
    <li class="@if($sidebar == 1 ) active @endif" >
      <a href="{{url('/resultAdmin')}}">
        <i class="fa fa-cube"></i>
        <span class="title">Applications Scores</span>
        <span class="selected"></span>
      </a>
    </li>
    <li class="@if($sidebar == 2 ) active @endif" >
      <a href="{{url('/resultAdmin/Parameter')}}">
        <i class="fa fa-lock"></i>
        <span class="title">Parameters</span>
        <span class="selected"></span>
      </a>
    </li>
    <li class="@if($sidebar == 3 ) active @endif" >
      <a href="{{url('/resultAdmin/coursesParameter')}}">
        <i class="fa fa-lock"></i>
        <span class="title">License Parameter</span>
        <span class="selected"></span>
      </a>
    </li>
    <!-- <li class="@if($sidebar == 4 ) active @endif" >
      <a href="{{url('/resultAdmin/result')}}">
        <i class="fa fa-lock"></i>
        <span class="title">Result</span>
        <span class="selected"></span>
      </a>
    </li> -->
    <li class="@if($sidebar == 4) active @endif" >
      <a href="{{url('/changePassword')}}">
        <i class="fa fa-lock"></i>
        <span class="title">Change Password</span>
        <span class="selected"></span>
      </a>
    </li>
  </ul>
</div>


