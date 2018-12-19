{{widget('modal')->label(trans('trans::downstream.edit_modal.title')." : ".$model->slug)->target(route('edit'))->validation(false)->method('get')->id('edit_trans')}}

<div class="modal-body">

	@if(dev())

		{!! widget('checkbox')
			 ->id('developer_only')
			->name("developer_only")
			->type('checkbox')
			->inForm()
			->value($model->developer_only)
			 ->label('tr:trans::downstream.developer_only')
		 !!}

		{!! widget('text')
			 ->id('slug')
			->name("slug")
			->type('text')
			->inForm()
			->value($model->slug)

			->required()
			 ->label('tr:trans::downstream.slug')
		 !!}
	@else
		{!! widget('hidden')
		 ->id('slug')
		->name("slug")
		->value($model->slug)
	 !!}
	@endif
	@foreach($locales as $locale)
		@php($trans=model('trans')->where('slug',$model->slug)->where('locale',$locale)->first())
		{!!
	   widget('textarea')
		->id($locale)
		->name("values[$locale]")
		->type('text')
		->inForm()
		->rows(1)
		->value(($trans)?$trans->value:"")
		->label(trans('trans::downstream.locales.'.$locale))
		!!}
	@endforeach


	<input type="hidden" value="{{$hashid}}" name="hashid">

	@include("manage::widgets101.feed",['container_id'=>"edit_trans",'container_class'=>'js','container_style'=>''])
</div>


<div class="modal-footer pv-lg">
	{!! widget('button')->type('submit')->id('edit-btn')->label(trans('trans::downstream.accept'))->class('btn-success')!!}
	{!! widget('button')->id('cancel-btn')->label(trans('trans::downstream.cancel'))->class(' btn-link btn-taha ')->onClick('$(".modal").modal("hide")')!!}

</div>
