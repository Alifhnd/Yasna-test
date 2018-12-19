{{--
---- Div.table-responsive added.
---- panel margin class commented
---- //Negar
--}}

<div class="panel panel-default {{--m20--}}">
	<div class="panel-body">
		<div class="table-type table-responsive">
			<table id="{{$table_id or ''}}" class="table tableGrid {{$table_class or 'table-hover'}}">
				<thead>
				<tr>
					@if(isset($handle) and str_contains($handle , 'selector'))
						<td width="50">
							{!!
							    widget('checkbox')
							    ->id('gridSelector-all')
							    ->onChange("gridSelector('all')")
							 !!}
						</td>
					@endif
					@if(isset($handle) and str_contains($handle , 'counter'))
						<td width="50">#</td>
					@endif

					@include("manage::widgets.grid-headings")


				</tr>
				</thead>
				<tbody>



				@if(0)
				</tbody>
			</table>
		</div>
	</div>
</div>
@endif
