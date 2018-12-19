@include('manage::layouts.modal-start' , [
'form_url' => route("tags.store"),
'modal_title' => trans_safe('post::message.new_tag'),
])


<div class="modal-body">

	{!!
			widget('input')
			->name($name = 'title')
			->inForm()
			->label(trans_safe('post::message.title'))
			->value($model->$name)
		!!}
</div>
<div class="modal-footer">
	@include('manage::forms.buttons-for-modal')
</div>