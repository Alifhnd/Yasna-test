
@include('manage::widgets.grid-row-handle', [
'refresh_url' => "",
])

<td>
	{{ $model->id  }}
</td>

<td>
	{{ $model->post_title }}
</td>

<td>
	{{ $model->status }}
</td>