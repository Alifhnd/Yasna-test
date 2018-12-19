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
	<td class="text-right" style="vertical-align: middle;">
		<button class="btn btn-danger  btn-outline btn-xs btn-remove-member" type="button"
				data-url="{{ route('users.departments.remove-member') }}"
				data-user="{{ $user->hashid }}"
				data-department="{{ $model->hashid }}">
			<span class="fa fa-times"></span>
		</button>
	</td>
</tr>
