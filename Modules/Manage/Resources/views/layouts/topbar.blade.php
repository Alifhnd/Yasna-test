<span id="spnTopbarNotification" data-src="manage/widget/topbar-notification" ondblclick="divReload('spnTopbarNotification')">
	<i class="fa fa-bell-o text-gray"></i>
	<script>divReload('spnTopbarNotification')</script>
</span>

@if(sizeof($topbar_create_menu = Manage::topbarCreateMenu() )>1)
	@include('manage.frame.widgets.topbar' , [
		'icon' => 'plus-circle' ,
		'items' => $topbar_create_menu ,
		'color' => 'green' ,
	])
@endif

{{--user list icon--}}
@include('manage::widgets.button-dropper' , [
	'icon' => 'user' ,
	'color' => 'grey' ,
	'text' => user()->full_name ,
	'items' => [
		['manage/account' , trans('manage::settings.account') , 'sliders'] ,
		['-'] ,
		['/logout' , trans('manage::template.logout') , 'sign-out'] ,
	]
])
