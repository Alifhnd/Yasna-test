@if ($meta['total'] > $meta['count'])
	@php
		$pages = $meta['pages'];
		$page_count = $pages['count'];
		$links  = $meta['links'];
		$url = request()->url() . "?page=";
	@endphp

	<div class="paginate">
		<ul class="pagination">

			{{-- Previous Page Link --}}
			@if ($pages['is_first'])
				<li class=" disabled" aria-disabled="true">
					<span aria-hidden="true">
						{{ trans('manage::template.prev') }}
					</span>
				</li>
			@else
				<li>
					<a href="{{ $url . ($pages['current'] - 1) }}" rel="prev" aria-label="{{ trans('manage::template.prev') }}">
						{{ trans('manage::template.prev') }}
					</a>
				</li>
			@endif


			{{-- All Pages Links --}}
			@for($i = 1; $i <= $page_count; $i++)

				@if ($i === $pages['current'])
					<li class="active" aria-current="page">
						<span>{{ ad($i) }}</span>
					</li>
				@else
					<li>
						<a href="{{ $url . $i }}">{{ ad($i) }}</a>
					</li>
				@endif

			@endfor




			{{-- Next Page Link --}}
			@if ($pages['has_more'])
				<li>
					<a href="{{ $url . ($pages['current'] + 1) }}" rel="next">
						{{ trans('manage::template.next') }}
					</a>
				</li>
			@else
				<li class="disabled" aria-disabled="true">
					<span aria-hidden="true">
						{{ trans('manage::template.next') }}
					</span>
				</li>
			@endif
		</ul>
	</div>
@endif


