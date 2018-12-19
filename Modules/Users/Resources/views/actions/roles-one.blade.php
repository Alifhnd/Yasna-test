@if(user()->as('admin')->can_any(["$role->slug.create" , "$role->slug.delete"]))
	@include("manage::forms.group-start" , [
		'label' => trans("users::permits.as_a" , [	"role_title" => $role->title ,]),
	])

	<div id="divRole-{{$role->id}}">
		@include("users::actions.roles-one-combo")
	</div>

	@include("manage::forms.group-end")
@endif