
{!! Form::open([
        'id' => 'frmMasterSearch',
        'url' => route('master-search') ,
        'method' =>'get' ,
        'class' => 'navbar-form',
        'role'=>"search",
    ]) !!}

    <div class="form-group has-feedback">
        <input type="text" placeholder="Type and hit enter ..." class="form-control" name="keyword">
        <div data-search-dismiss="" class="fa fa-times form-control-feedback"></div>
    </div>
    <button type="submit" class="hidden btn btn-default">Submit</button>


{!! Form::close() !!}