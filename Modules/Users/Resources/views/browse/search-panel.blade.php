<div class="panel panel-default m20">

	@include('manage::forms.opener',[
		'url' => $search_url ,
		'class' => 'js-' ,
		'method' => 'get',
	])

	<br>

	@include('manage::forms.input' , [
		'name' => 'keyword',
		'class' => 'form-required form-default'
	])

	@include('manage::forms.group-start')

	@include('manage::forms.button' , [
		'label' => trans('manage::forms.button.search'),
		'shape' => 'success',
		'type' => 'submit' ,
	])

	@include('manage::forms.group-end')

	@include('manage::forms.feed' , [])

	@include('manage::forms.closer')
</div>
