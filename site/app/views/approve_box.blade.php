@if(Auth::user()->privilege == 2)
  <div class="portlet green box">
    <div class="portlet-title" >
      <div class="caption">
        Comment Box
      </div>
    </div>
    <div class="portlet-body log-body">
      <div class="row">
        {{Form::open(array('url'=>'approve/'.$entity_type.'/'.$entity_id,'method'=>'post','files'=>'true','class'=>""))}}
          <div class="col-md-4" @if(Session::get('privilege') != 2) hidden @endif>
            <label>Status</label><br>
            {{Form::radio('type',1, true)}} Approve <br>
            @if(Session::get('privilege') == 2)
              @if(isset($show_refer)) @if($show_refer == 1) {{Form::radio('type',2)}} Refer Back <br> @endif @endif
              {{Form::radio('type',3)}} Reject <br>
            @endif
          </div>
          <div class="col-md-8">
              <div class="">
                <label>Remarks</label>
                {{Form::text('remarks','',["class"=>"form-control","required"=>"true"])}}
              </div>
              <div style="display: none">
                <label>Document</label>
                {{Form::file('document',["class"=>'form-control',"pdf"=>true])}}
              </div>
          </div>
          <div class="col-md-12">
            {{Form::submit('Submit',["class"=>"btn green btn-sm","style"=>"margin-top:20px"])}}
          </div>
        {{Form::close()}}
      </div>
    </div>
  </div>
@endif