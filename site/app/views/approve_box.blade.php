<div class="portlet green box">
  <div class="portlet-title" >
    <div class="caption">
      Status
    </div>
  </div>
  <div class="portlet-body log-body">
    <div class="row">
      {{Form::open(array('url'=>'approve/1/'.$coach->id,'method'=>'post','files'=>'true','class'=>"check_form"))}}
        <div class="col-md-3">
          <label>Status</label><br>
          {{Form::radio('type',1, true)}} Approve <br>
          {{Form::radio('type',2)}} Refer Back <br>
          {{Form::radio('type',3)}} Reject <br>
        </div>
        <div class="col-md-5">
          <label>Remarks</label><br>
          {{Form::text('remarks','',["class"=>"form-control","required"=>"true"])}}
        </div>
        <div class="col-md-4">
          <label>Document</label><br>
          {{Form::file('document')}}
        </div>
        <div class="col-md-12">
          {{Form::submit('Submit',["class"=>"btn green btn-sm","style"=>"margin-top:20px"])}}
        </div>
      {{Form::close()}}
    </div>
  </div>
</div>