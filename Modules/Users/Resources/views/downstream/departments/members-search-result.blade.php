<div class="row">
	<table class="table">
		<tbody>
		<tr>
			<td>
				@include("manage::widgets.grid-text" , [
					'text' => $user->full_name,
					'class' => "font-yekan" ,
					'size' => "14",
				])
				@include("manage::widgets.grid-text" , [
					'text' => $user->$username_field,
					'class' => "font-yekan" ,
					'color' => 'gray',
					'size' => "14",
				])
			</td>
			<td class="text-right" style="vertical-align: middle">
				@if ($is_member)
					<span class="text-success">
						<span class="fa fa-check"></span>
						{{ trans_safe('users::department.is-member') }}
					</span>
				@else
					<button class="btn btn-success btn-outline btn-xs btn-add-member" type="button"
							data-url="{{ route('users.departments.add-member') }}"
							data-user="{{ $user->hashid }}"
							data-department="{{ $role->hashid }}">
						<span class="fa fa-plus"></span>
					</button>
				@endif
			</td>
		</tr>

		</tbody>
	</table>
</div>
