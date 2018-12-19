{{--
|--------------------------------------------------------------------------
| Name
|--------------------------------------------------------------------------
|
--}}


<div class="font-yekan text-bold f20">
	{{ user()->full_name }}
</div>


{{--
|--------------------------------------------------------------------------
| Buttons
|--------------------------------------------------------------------------
| 
--}}

<div class="row" style="margin-top: 30px">
	<div class="col-md-4">
		{!!
		widget("link")
			->label('tr:manage::settings.account')
			->target('url:manage/account')
			->icon('user')
		!!}
	</div>
	{{--<div class="col-md-4">--}}

	{{--</div>--}}
	<div class="col-md-5">
		{!!
		widget("link")
			->label('tr:manage::template.logout')
			->target('url:logout')
			->color('danger')
			->icon('sign-out')
		!!}
	</div>
</div>