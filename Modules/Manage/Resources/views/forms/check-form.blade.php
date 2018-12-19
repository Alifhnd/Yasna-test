@if(!isset($condition) or $condition)
	@include('manage::forms.group-start')

	@include('manage::forms.form-el.checkbox' , [
		'label' => $self_label
	])

	@include('manage::forms.group-end')

@endif