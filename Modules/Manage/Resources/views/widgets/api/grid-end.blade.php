@if(0)
	<div>
		<div>
			<div>
				<table>
					<tbody>
					@endif


					@if(1)
					</tbody>
				</table>
			</div>
			<div class="grid_count">
				@if($meta['count'] and $meta['total'])
					{{ trans("manage::forms.feed.showing_x_numbers_out_of_total" , [
						'x' => pd($meta['count']) ,
						'total' => pd($meta['total']) ,
					]) }}
				@endif
			</div>
		</div>
	</div>
@endif
