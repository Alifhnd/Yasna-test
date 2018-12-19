<div class="panel panel-default" style="margin-top: 10px">
		<table class="table">
			<tbody>
			@php $users = $model->users @endphp
			@if($users->count())
				@foreach($users as $user)
					@include('users::downstream.departments.members-row')
				@endforeach
			@else
				<tr>
					<td colspan="10">
						<div class="null">
							{{ trans('manage::forms.feed.nothing') }}
						</div>
					</td>
				</tr>
			@endif

			</tbody>
		</table>

</div>
