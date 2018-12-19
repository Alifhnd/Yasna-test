@extends('manage::layouts.template')
@section('content')
	@include("manage::downstream.tabs")
	<div class="col-xs-12">
		@include("manage::widgets.toolbar" , [
		'buttons' => [
		[
			'type' => "info",
			'caption' => trans('trans::downstream.excel.export'),
			'icon' => "file-excel-o",
			'target' => "modal:" . route('manage.trans.export_modal'),
			'condition'=>dev()
			],
			[
			'type' => "info",
			'caption' => trans('trans::downstream.excel.import'),
			'icon' => "file-excel-o",
			'target' => "modal:" . route('manage.trans.import_modal'),
			'condition'=>dev()
			],
		[
			'type' => "primary",
			'caption' => trans('trans::downstream.add'),
			'icon' => "plus",
			'target' => "modal:" . route('add-modal', ['hash_id' => hashid(0)],false),
			'condition'=>dev()
			],
			],
			'search' => [
			'target' => url('manage/downstream/trans'),
            'label'  => trans('trans::downstream.search'),
            'value'  => ($request->has('keyword'))?$request->get('keyword'):'',
    	 ],
			'title' => trans('trans::downstream.page_title')
		])
	</div>
	{{--@include("manage::widgets.toolbar")--}}
	<div class="row">
		<div class="col-md-12">
			@include("manage::widgets.grid" , [
				'table_id' => "translations" ,
				'row_view' => "trans::downstream.grid" ,
				'handle'=>'selector',
				'headings' => [
				trans('trans::downstream.list.title'),
				trans('trans::downstream.list.locales'),
				trans('trans::downstream.list.actions'),
				] ,
			]     )

		</div>
	</div>
@stop
