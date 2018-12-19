

<select
		id="{{ $id }}"
		name="{{ $name }}"
		value="{{ $value }}"
		class="form-control selectpicker {{ $class }}"
		placeholder="{{ $placeholder }}"
		data-size="{{ $size }}"
		data-live-search="{{ $searchable }}"
		data-live-search-placeholder="{{ $search_placeholder }}..."
		onchange="{{ $on_change }}"
		{{ $extra }}
>


	{{-- Blank Value -------------------------------}}
	@if(isset($blank_value))
		<option value="{{$blank_value}}"
				@if($value==$blank_value)
				selected
				@endif
		>{{ $blank_caption }}</option>
	@endif



	{{-- Real Options -------------------------------}}

	@foreach($options as $option)

		<option
				@if(str_contains($option[ $caption_field ],"fa-"))
				data-content='<i class="fa mh10 {{ $option[ $caption_field ] }}" aria-hidden="true"></i>
					{{ $option[ $caption_field ] }}'

				@else
					data-content="{{$option[ $caption_field ]}}"
				@endif
				value="{{$option[$value_field]}}"
				@if($value==$option[$value_field])
				selected
				@endif
		>
		</option>
	@endforeach
</select>

@if($help)
	<span class="help-block {{ $help_class }}" style="{{ $help_style }}" onclick="{{ $help_click }}">
			{{ $help }}
		</span>
@endif


