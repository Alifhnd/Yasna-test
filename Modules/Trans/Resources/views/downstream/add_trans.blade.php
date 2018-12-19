{{widget('modal')->label(trans('trans::downstream.add_modal'))->target(url('trans/add'))->validation(false)->method('get')->id('add_trans')}}

<div class="modal-body">

	{!! widget('checkbox')
	 ->id('developer_only')
	->name("developer_only")
	->type('checkbox')
	->inForm()
	->value()
	 ->label('tr:trans::downstream.developer_only')
 !!}

	{!! widget('text')
		 ->id('slug')
		->name("slug")
		->type('text')
		->inForm()
		->required()
		 ->label('tr:trans::downstream.slug')
	 !!}

	@foreach($locales as $locale)
		{!!
	   widget('textarea')
		->id($locale)
		->name("values[$locale]")
		->type('text')
		->inForm()
		->value()
		->rows(1)
		->autoSize()
		->label(trans('trans::downstream.locales.'.$locale))
		!!}
	@endforeach

	@include("manage::widgets101.feed",['container_id'=>"add_trans",'container_class'=>'js','container_style'=>''])

</div>

<div class="modal-footer pv-lg">
	{!! widget('button')->type('submit')->id('add-btn')->label(trans('trans::downstream.accept'))->class('btn-success')!!}
	{!! widget('button')->id('cancel-btn')->label(trans('trans::downstream.cancel'))->class(' btn-link btn-taha ')->onClick('$(".modal").modal("hide")')!!}

</div>
