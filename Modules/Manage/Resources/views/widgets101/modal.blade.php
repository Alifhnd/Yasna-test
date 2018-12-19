{{--
|--------------------------------------------------------------------------
| Title
|--------------------------------------------------------------------------
|
--}}

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 id="{{ $id }}-title" class="modal-title">
		@if($blade)
			@include($blade)
		@else
			{{ $label }}
		@endif
	</h4>
</div>


{{--
|--------------------------------------------------------------------------
| Form
|--------------------------------------------------------------------------
| only if a $target is set.
--}}

@if($target)
	@include( widget()->viewPath( 'form' ) , [
		'id' => "$id-form" ,
	])

	{{
	widget('hidden')
		->name("_modal_id")
		->value($id)
		->render()
	}}
@endif
