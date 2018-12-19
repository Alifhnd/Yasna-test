<div id="{{ $container_id }}" class="{{ $container_class }}" style="{{ $container_style }}" {{ $container_extra }}>
	<div>
		<hr class="separator {{ $class }}">
		@if($label)
			<div class="{{ $label_class  }}" style="margin-bottom: 20px; {{ $label_style }}">{{ $label }}...</div>
		@endif
	</div>
</div>