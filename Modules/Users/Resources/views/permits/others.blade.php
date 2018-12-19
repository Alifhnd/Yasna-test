@foreach($modules as $module => $permits)
	@if( !in_array($module , service("users:permit_tabs")->paired('key') ) )
		@include("users::permits.module" , [
			'title' => $request_role->trans($module),
			'module' => $module ,
			'permits' => $permits ,
		]     )
	@endif
@endforeach

