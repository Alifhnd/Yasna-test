@include("manage::widgets.toolbar" , [
    'buttons' => [
         [
              'target' => "modal:manage/upstream/roles/admins/0" ,
              'type' => "warning" ,
              'caption' => trans("users::permits.all_admin_roles") ,
              'icon' => "grav" ,
         ],
         [
              'target' => "modal:manage/upstream/roles/create/0",
              'type' => "success",
              'caption' => trans('manage::forms.button.add'),
              'icon' => "plus-circle",
         ],
    ],
    'search' => [
         'target' => url('manage/upstream/roles/') ,
         'label' => trans('manage::forms.button.search') ,
         'value' => isset($keyword)? $keyword : '' ,
    ],
])
