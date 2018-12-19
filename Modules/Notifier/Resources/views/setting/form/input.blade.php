<div class="panel-cols mb">
	<label class="panel-col">
		{{ $label }}
	</label>
	<div class="panel-col-3">
		{!!
			widget('input')
			->name($name)
			->value($value)
		 !!}
	</div>

</div>
