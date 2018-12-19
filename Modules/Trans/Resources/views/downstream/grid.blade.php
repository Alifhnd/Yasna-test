@include('manage::widgets.grid-row-handle', [
	'handle' => "selector" ,
    'refresh_url' => url('trans/update/row/'.$model->hashid),
])

{{--@include('manage::widgets.grid-rowHeader' , [--}}
{{--'handle' => "counter" ,--}}
{{--'i' => $offset + $i--}}
{{--])--}}

@include("trans::downstream.value_col")

<td>{{implode(" ، ",$model->getLocalesTrans())}}</td>

@include("manage::widgets.grid-actionCol" , [
"actions" => [
 ['edit',trans('trans::downstream.list.edit'), 'modal:trans/edit_modal/-hashid-'],
  ['trash',trans('trans::downstream.list.delete'), 'modal:trans/delete_modal/-hashid-',dev()],
],
"button_label" =>  trans('trans::downstream.list.actions'),
"button_size"  => "xs" ,  //default: 'xs'
"button_class" => 'default'  //default: 'default'
])