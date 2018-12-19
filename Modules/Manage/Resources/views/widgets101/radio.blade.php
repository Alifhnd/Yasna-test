@foreach($options as $option)
	<div class="radio c-radio {{$class}}">
		<label>
			<input
					type="radio"
					value="{{ $option[$value_field] }}"
					id="{{ $id }}"
					name="{{ $name }}" {{ $value ==  $option[$value_field] ? "checked='checked'" : ''}}
					onchange="{{ $on_change }}"
					onclick="{{ $on_click }}"
			>
			<span class="fa fa-circle"></span>
			{{ $option[ $caption_field ] }}
		</label>
	</div>
@endforeach
