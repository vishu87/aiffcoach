@if(Session::has('success'))
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
        {{Session::get('success')}}
    </div>
@endif

@if(Session::has('failure'))
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <i class="fa fa-ban-circle"></i><strong>Failure!</strong> {{Session::get('failure')}}
    </div>
@endif
<div class="portlet box blue">
    <div class="portlet-title"><div class="caption">Change Password</div></div>
        <div class="portlet-body form">
            {{Form::open(array('url'=>'/updatePassword','class'=>'form','method'=>'post'))}}
            <div class="form-body">
                <div class="form-group">
                    <label>Old Password</label>
                        {{Form::password('oldpwd',["class"=>"form-control","required"=>"true"])}}
                        <span class="error">{{$errors->first('oldpwd')}}</span>
                </div>
                <div class="form-group">
                    <label>New Password</label>                        
                        {{Form::password('newpwd',["class"=>"form-control","required"=>"true"])}}
                        <span class="error">{{$errors->first('newpwd')}}</span>
                </div>

                <div class="form-group">
                    <label>Confirm Password</label>
                        {{Form::password('conpwd',["class"=>"form-control","required"=>"true"])}}
                        <span class="error">{{$errors->first('conpwd')}}</span>
                </div>
            </div> 
            <div class="form-actions">
                <button class="btn btn-primary" type="submit">Update</button>
            </div>   
            {{Form::close()}}  
        </div>
    </div>
</div>
