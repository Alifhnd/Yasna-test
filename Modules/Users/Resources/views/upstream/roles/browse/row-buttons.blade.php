<td>
    @include("manage::widgets.grid-text" , [
         'text' => trans('manage::forms.button.edit'),
         'class' => "btn btn-default" ,
         'link' =>  "modal:manage/upstream/roles/edit/-hashid-" ,
    ])
</td>

<td>
    @include("manage::widgets.grid-text" , [
         'text' => trans('manage::settings.title_in_other_locales'),
         'class' => "btn btn-default" ,
         'link' =>  "modal:manage/upstream/roles/titles/-hashid-" ,
    ])
</td>
