@extends('manage::layouts.template')

@section('content')

	{{--
	|--------------------------------------------------------------------------
	| Toolbar
	|--------------------------------------------------------------------------
	|
	--}}
	@include("manage::widgets.toolbar" , [
		'title' => $page[0][1] ,
		'buttons' => [
			[
				'target' => "manage/statue/op-cache",
				'type' => "warning",
				'caption' => "OP Cache Reset",
				'icon' => "cloud",
				'condition' => user()->isDeveloper() ,
			],
			[
				'target' => "manage/statue/init",
				'type' => "primary",
				'caption' => trans('manage::statue.init'),
				'icon' => "database",
				'condition' => user()->isDeveloper() ,
			],
		]
	])

	{{--
	|--------------------------------------------------------------------------
	| Grid
	|--------------------------------------------------------------------------
	|
	--}}
	@include("manage::widgets.grid" , [
		'table_id' => "tblStatue",
		'row_view' => "manage::statue.row",
		'handle' => "counter",
		'headings' => [
			trans('validation.attributes.title'),
			trans("manage::statue.version") ,
			trans("validation.attributes.status"),
		],
	])



@stop