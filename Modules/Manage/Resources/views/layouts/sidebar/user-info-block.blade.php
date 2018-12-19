<!-- Name and Job-->
<div class="user-block-info">
@include('manage::layouts.sidebar.user-info',[
	"class" => "user-block-name",
	"text" => user()->full_name
])

{{--@include('manage::layouts.sidebar.user-info',[
	"class" => "user-block-role",
	"text" => "طراح وب"
])--}}

<!-- logout link -->
	<a href="{{ url('logout') }}" class="user-block-role">{{ trans('manage::template.logout') }}</a>

</div>