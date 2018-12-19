@extends('manage::layouts.template')

@section('content')
	@include("manage::upstream.tabs")

	@include("manage::widgets.toolbar" , [
	'buttons' => [
		[
			'target' => "modal:manage/upstream/setting/create",
			'type' => "success",
			'caption' => trans('manage::forms.button.add'),
			'icon' => "plus-circle",
		],
	],
	'search' => [
		'target' => url('manage/upstream/settings/') ,
		'label' => trans('manage::forms.button.search') ,
		'value' => isset($keyword)? $keyword : '' ,
	],
])

	@include("manage::widgets.grid" , [
		'table_id' => "tblSettings",
		'row_view' => "manage::upstream.settings-row",
		'handle' => "",
		'headings' => [
			'#',
			trans('validation.attributes.title'),
			trans("validation.attributes.category"),
			trans('validation.attributes.status'),
			trans('manage::forms.button.action'),
		],
	])

@endsection