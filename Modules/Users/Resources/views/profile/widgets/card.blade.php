<div class="panel b0 bg-{{ $color or 'green' }}">
	<div class="panel-heading b0">
		<div class="row">
			<div class="col-xs-3">
				<em class="fa fa-{{ $icon or 'file-o' }} fa-5x"></em>
			</div>
			<div class="col-xs-9 text-right">
				<div class="text-lg">
					{{ ad($count) }}
				</div>
				<p class="m0">
					{{ $title }}
				</p>
			</div>
		</div>
	</div>
	@isset($link)
	<a href="{{ $link }}" class="panel-footer bg-gray-dark bt0 clearfix btn-block">
		<span class="pull-left">
			{{ trans('users::profile.details_view') }}
		</span>
		<span class="pull-right">
		   <em class="fa fa-chevron-circle-{{ isLangRtl() ? 'left' : 'right' }}"></em>
		</span>
	</a>
	@endisset
</div>
