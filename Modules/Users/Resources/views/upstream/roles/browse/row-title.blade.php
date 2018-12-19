@include("manage::widgets.grid-text" , [
     'text' => $model->title,
     'size' => "16" ,
     'class' => "font-yekan text-bold" ,
     'link' =>  "modal:manage/upstream/roles/edit/-hashid-" ,
])

@include("manage::widgets.grid-tiny" , [
     'text' => "$model->id|$model->slug" ,
     'color' => "gray" ,
     'icon' => "bug",
     'class' => "font-tahoma" ,
     'locale' => "en" ,
]     )

