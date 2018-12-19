<div class="panel panel-default w80 mv30">
	<div class="panel-heading">
		<i class="fa fa-user"></i>
		<span class="mh5">
				{{$page[1][1]}}
			</span>
	</div>
	<div class="panel-body p10">
		@include('manage::forms.opener',[
			'url' => url('manage/account/save/personal') ,
			'class' => "js",
		])
		@include('manage::account.avatar')

		@include('manage::forms.input' , [
			'name' => '',
			'label' => trans('validation.attributes.username'),
			'value' => user()->toArray()[config('auth.providers.users.field_name')] ,
			'disabled' => true ,
		])

		@include("manage::forms.input" , [
			'name' => "name_first",
			'value' => user()->name_first ,
			'class' => "form-required" ,
		]     )

		@include("manage::forms.input" , [
			'name' => "name_last",
			'value' => user()->name_last ,
			'class' => "form-required" ,
		]     )

		@include("manage::forms.input" , [
			'name' => "tel_emergency",
			'value' => user()->tel_emergency ,
			'class' => "ltr" ,
		]     )


		@include('manage::forms.group-start')

		@include('manage::forms.button' , [
			'label' => trans('manage::forms.button.save'),
			'shape' => 'primary',
			'type' => 'submit' ,
		])
		@include('manage::forms.button' , [
			'label' => trans('manage::forms.button.cancel'),
			'shape' => 'link',
			'link' => 'window.history.back()',
		])

		@include('manage::forms.group-end')

		@include('manage::forms.feed')

		@include("manage::forms.closer")
	</div>
</div>
