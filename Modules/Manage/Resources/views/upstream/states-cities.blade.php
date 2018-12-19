@extends('manage::layouts.template')

@section('content')
	@include("manage::upstream.tabs")

	@include("manage::widgets.toolbar" , [
		'title' => $page[1][1].' / '.$page[2][1],
		'buttons' => [
			[
				'condition' => isset($state),
				'target' => "modal:manage/upstream/state/cities-create/".(isset($state)?$state->hashid:''),
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
		'row_view' => "manage::upstream.states-cities-row",
		'handle' => "counter",
		'headings' => [
			trans('yasna::states.city'),
			'',
			trans('validation.attributes.province_id'),
			trans('validation.attributes.domain'),
			trans('validation.attributes.action')
		],
	])

@endsection