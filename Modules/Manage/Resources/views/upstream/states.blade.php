@extends('manage::layouts.template')

@section('content')
	@include("manage::upstream.tabs")

	@include("manage::widgets.toolbar" , [
		'buttons' => [
			[
				'target' => "modal:manage/upstream/state/create",
				'type' => "success",
				'caption' => trans('manage::forms.button.add'),
				'icon' => "plus-circle",
			],
		],
		'search' => [
			'target' => url('manage/upstream/states/search/') ,
			'label' => trans('manage::forms.button.search') ,
			'value' => isset($keyword)? $keyword : '' ,
		],
	])

	@include("manage::widgets.grid" , [
		'table_id' => "tblStates",
		'row_view' => "manage::upstream.states-row",
		'handle' => "counter",
		'headings' => [
			trans('validation.attributes.province_id'),
			trans('validation.attributes.capital_id'),
			trans('validation.attributes.cities'),
			trans('validation.attributes.action')
		],
	])

@endsection