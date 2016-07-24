<?php 
	if($flag==1){
		$width = 35.05;
	}
	elseif ($flag==2) {
		$width = 68.10;
	}
	else{
		$width = 100;
	}
?>
<div class="col-md-12">
  	<ul class="nav  nav-justified steps">
      <li <?php if($flag==1):echo 'class="active"'; endif;?>>
        
        <span class="number">
        1 </span>
        <span class="desc">
         Registration Details</span>
        
      </li>
      <li <?php if($flag==2):echo 'class="active"'; endif;?>>
        
        <span class="number">
        2 </span>
        <span class="desc">
         Contact Details </span>
        
      </li>
      <li <?php if($flag==3):echo 'class="active"'; endif;?>>
        
        <span class="number">
        3 </span>
        <span class="desc">
         Confirm </span>
        
      </li>
    </ul>
    <div id="bar" class="progress progress-striped" role="progressbar">
        <div class="progress-bar progress-bar-success" style="width:<?php echo $width.'%';?>">
        </div>
    </div>
</div>