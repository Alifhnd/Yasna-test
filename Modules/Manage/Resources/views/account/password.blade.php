@extends('manage::layouts.template')

@section('content')
	@include("manage::account.tabs")

	<div class="panel panel-default w80 mv30">
		<div class="panel-heading">
			<i class="fa fa-key"></i>
			<span class="mh5">
				{{trans('manage::settings.change_password')}}
			</span>
		</div>
		<div class="panel-body p10">
			@include('manage::forms.opener',[
				'url' => url('manage/account/save/password') ,
				'class' => "js",
			])

			@include('manage::forms.input' , [
				'name' => '',
				'label' => trans('validation.attributes.name_first'),
				'value' => user()->full_name ,
				'disabled' => true ,
			])

			@include("manage::forms.input" , [
				'name' => "current_password",
				'class' => "form-required ltr",
				'type' => "password",
			])
			@include("manage::forms.input" , [
				'name' => "new_password",
				'class' => "form-required ltr",
				'type' => "password",
			])
			@include("manage::forms.input" , [
				'name' => "password2",
				'class' => "form-required ltr",
				'type' => "password",
			])

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

@endsection