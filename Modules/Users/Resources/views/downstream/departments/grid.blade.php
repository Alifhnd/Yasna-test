<div class="row" id="browse-grid">
	<span class="hidden refresh">{{ route('users.departments.grid') }}</span>

	<div class="col-xs-12">
		@include("manage::widgets.grid" , [
			'table_id' => "tblRoles",
			'table_class' => 'tbl-accounts',
			'row_view' => "users::downstream.departments.browse-row",
			'handle' => "counter",
			'models' => $models,
			'headings' => [
				trans('validation.attributes.title'),
				trans('manage::forms.button.action'),
			],
		])
	</div>
</div>
