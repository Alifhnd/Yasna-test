<div class="row">
	@foreach( module('manage')->service('downstream')->read() as $tab )
		<div class="col-md-4 mv10 text-center">
			{!!
			widget("link")
				->class('btn btn-purple')
				->label($tab['caption'])
				->target('url:manage/downstream/' . $tab['link'])
				->style('min-width:90%')
			!!}
		</div>
	@endforeach
</div>