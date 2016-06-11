<div class="page-sidebar navbar-collapse collapse">
  <ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
    <li class="sidebar-toggler-wrapper">
      <div class="sidebar-toggler">
      </div>
    </li>
    <li style="height:10px">
    </li>

    
    <li class="@if($sidebar == 1 ) active open @endif">
      <a href="javascript:;">
      <i class="fa fa-edit"></i>
      <span class="title">Applications</span>
      <span class="arrow @if($sidebar == 1 ) open @endif"></span>
      </a>
      <ul class="sub-menu">
        <li class="@if($sidebar == 1 && $subsidebar == 1 ) active @endif">
          <a href="{{url('admin/Applications/approved')}}">
          <i class="fa fa-chevron-right"></i>
          Approved</a>
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


