@include("manage::widgets.grid" , [
     'table_id' => "tblRoles",
     'row_view' => "users::upstream.roles.browse.row",
     'handle' => "counter",
     'headings' => [
          trans('validation.attributes.title'),
//          trans('validation.attributes.status'),
          ['',60],
          '',
          [trans('users::forms.people'),200],
          trans('manage::forms.button.action'),
     ],
])
