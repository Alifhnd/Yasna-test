<div class="row">
	@foreach( module('manage')->service('upstream_tabs')->read() as $tab )
		<div class="col-md-4 mv10 text-center">
			{!!
			widget("link")
				->class('btn btn-inverse')
				->label($tab['caption'])
				->target('url:manage/upstream/' . $tab['link'])
				->style('min-width:90%')
			!!}
		</div>
	@endforeach
</div>