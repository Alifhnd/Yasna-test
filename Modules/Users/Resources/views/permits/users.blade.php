@if(isset($modules['users']))
    @php
        $module_users = $modules['users'];
    @endphp

	@foreach($roles as $role)
		@include("users::permits.module" , [
			'title' => $role->plural_title,
			'module' => "users-$role->slug" ,
			'permits' => $module_users ,
		]     )
	@endforeach
	@include("users::permits.module" , [
		'title' => trans("users::forms.all_users"),
		'module' => "users-all" ,
		'permits' => $module_users ,
	]     )
@endif
