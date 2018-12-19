{{widget('modal')->label(trans('trans::downstream.delete_modal.title'))->target(route('delete'))->method('get')->id('delete_trans')}}

<div class="modal-body">
	{!! widget('text')
		 ->id('slug')
		->name("slug")
		->type('text')
		->inForm()
		->value($model->slug)
		->disabled()
		 ->label('tr:trans::downstream.slug')
	 !!}
	<input type="hidden" value="{{$hashid}}" name="hashid">

	@include("manage::widgets101.feed",['container_id'=>"delete_trans",'container_class'=>'js','container_style'=>''])
</div>


<div class="modal-footer pv-lg">
	{!! widget('button')->type('submit')->id('delete-btn')->label(trans('trans::downstream.accept'))->class('btn-danger')!!}
	{!! widget('button')->id('cancel-btn')->label(trans('trans::downstream.cancel'))->class(' btn-link btn-taha ')->onClick('$(".modal").modal("hide")')!!}

</div>