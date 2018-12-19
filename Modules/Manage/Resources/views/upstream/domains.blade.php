@extends('manage::layouts.template')

@section('content')
	@include("manage::upstream.tabs")

	@include("manage::widgets.toolbar" , [
		'buttons' => [
			[
				'target' => "modal:manage/upstream/domain/create",
				'type' => "success",
				'caption' => trans('manage::forms.button.add'),
				'icon' => "plus-circle",
			],
		],
		'search' => [
			'target' => url('manage/upstream/domains/search/') ,
			'label' => trans('manage::forms.button.search') ,
			'value' => isset($keyword)? $keyword : '' ,
		],
	])

	@include("manage::widgets.grid" , [
		'table_id' => "tblDomains",
		'row_view' => "manage::upstream.domains-row",
		'handle' => "counter",
		'headings' => [
			trans('validation.attributes.title'),
			trans('validation.attributes.alias'),
			trans('validation.attributes.cities'),
			trans('validation.attributes.action')
		],
	])

@endsection