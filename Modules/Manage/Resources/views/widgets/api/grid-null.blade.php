@if( $meta['count'] == 0)
	<tr>
		<td colspan="{{$colspan or '10'}}">
			<div class="null">
				{{ trans('manage::forms.feed.nothing') }}
			</div>
		</td>
	</tr>
@endif
