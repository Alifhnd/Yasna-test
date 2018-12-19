@include("manage::widgets.grid-badge" , [
     'icon' => manageStatus($model->status , 'icon') ,
     'text' => manageStatus($model->status , 'text'),
     'color' => manageStatus($model->status , 'color'),
     'link' => "modal:manage/upstream/roles/activeness/-hashid-" ,
])
@if($model->is_admin)
    @include("manage::widgets.grid-badge" , [
         'icon' => "user-secret",
         'text' => trans('users::permits.is_admin') ,
         'color' => "warning" ,
    ]     )
@endif

@if($model->is_support)
    @include("manage::widgets.grid-badge" , [
         'icon' => "ambulance",
         'text' => trans('users::permits.is_support') ,
         'color' => "info" ,
    ]     )
@endif


