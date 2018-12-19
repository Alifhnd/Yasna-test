@php($persian_value=model('trans')->where('slug',$model->slug)->where('locale','fa')->first())
@if($persian_value )
	<td>{{str_limit($persian_value->value,15)}}
		@if(dev())
			@include("manage::widgets.grid-tiny" , [
		'text' => "$model->id|$model->hashid" ,
		'color' => "gray" ,
		'icon' => "bug",
		'class' => "font-tahoma" ,
		'locale' => "en" ,
		]     )
		@endif
	</td>
@else
	<td>{{str_limit($model->value,15)}}
		@if(dev())
			@include("manage::widgets.grid-tiny" , [
		'text' => "$model->id|$model->hashid" ,
		'color' => "gray" ,
		'icon' => "bug",
		'class' => "font-tahoma" ,
		'locale' => "en" ,
		]     )
		@endif
	</td>
@endif
