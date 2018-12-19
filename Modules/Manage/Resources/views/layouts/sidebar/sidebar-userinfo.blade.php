<li class="has-user-block">
	<div id="user-block" class="collapse">
		<div class="item user-block">
			@foreach(service('manage:user_info_sidebar')->read() as  $item)
				@include($item['blade'])
			@endforeach
		</div>
	</div>
</li>