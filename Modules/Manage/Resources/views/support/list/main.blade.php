@extends('manage::layouts.template')

@section('content')
	@include($__module->getBladePath('widgets.toolbar'), ['title' => $page[0][1]])
	@include($__module->getBladePath('widgets.api.grid'), [
		'table_id' => "tbl-tickets" ,
		'row_view' => $__module->getBladePath('support.list.row'),
		'headings' => [
			trans('validation.attributes.title'),
			$__module->getTrans('support.priority'),
		],
		'handle' => "counter" ,
		//'operation_heading' => true,
	])
@append
