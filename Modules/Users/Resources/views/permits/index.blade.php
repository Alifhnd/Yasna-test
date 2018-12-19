@if($request_role->isPrivileged())
    @include("users::permits.tabs")

    @include("users::permits.panels")

    @include("manage::forms.textarea" , [
         'name' => "permissions",
         'id' => "txtPermissions" ,
         'class' => "ltr noDisplay" ,
         'value' => $model->as($request_role)->getPermissions() ,
         'in_form' => false ,
    ]     )

    <script>permitSpread()</script>
@else
    @include("users::permits.hello")
@endif

