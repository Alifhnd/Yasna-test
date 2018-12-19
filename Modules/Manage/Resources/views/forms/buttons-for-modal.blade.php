@if(isset($separator) and $separator)
	@include("manage::forms.sep")
@endif

@include("manage::forms.group-start")

{{--
|--------------------------------------------------------------------------
| Save Button
|--------------------------------------------------------------------------
|
--}}

@include('manage::forms.button' , [
	'id' => 'btnSave' ,
	'label' => isset($save_label)? $save_label : trans('manage::forms.button.save'),
	'shape' => isset($save_shape)? $save_shape : 'success',
	'value' => isset($save_value)? $save_value : 'save' ,
	'type' => isset($save_type)? $save_type : 'submit' ,
	'link' => isset($save_link)? $save_link : null
])


{{--
|--------------------------------------------------------------------------
| Extra Button (optional)
|--------------------------------------------------------------------------
|
--}}
@if(isset($extra_label))
	@include('manage::forms.button' , [
		'label' => $extra_label ,
		'id' => isset($extra_id)? $extra_id : 'btnExtra',
		'shape' => isset($extra_shape)? $extra_shape : 'default',
		'value' => isset($extra_value)? $extra_value : 'extra',
		'type' => isset($extra_type)? $extra_type : 'submit' ,
		'link' => isset($extra_link)? $extra_link : null  ,
	]      )

@endif


{{--
|--------------------------------------------------------------------------
| Cancel Button
|--------------------------------------------------------------------------
|
--}}

@include('manage::forms.button' , [
	'label' => trans('manage::forms.button.cancel'),
	'id' => "btnCancel" ,
	'shape' => 'link',
	'link' => isset($cancel_link) ? $cancel_link : '$(".modal").modal("hide")'
])

@include("manage::forms.group-end")

@if(!isset($no_feed) or !$no_feed)
    @include('manage::forms.feed')
@endif
