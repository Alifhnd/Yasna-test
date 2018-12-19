@if($model->trashed())
    -
@else
    @include("manage::widgets.grid-text" , [
         'text' => trans("users::forms.people") ,
         'link' => $model->trashed()? '' : "urlN:".$model->users_browse_link ,
    ])
    @include("manage::widgets.grid-text" , [
         'text' => trans("manage::forms.button.count"),
         'link' => "divReload('tdCount-$model->hashid')" ,
         'size' => "10" ,
         'color' => "darkgray" ,
    ]     )
@endif
