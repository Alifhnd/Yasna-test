@if(!isset($condition) or $condition)

	{{--
	|--------------------------------------------------------------------------
	| Preparations
	|--------------------------------------------------------------------------
	|
	--}}
    <?php
    isset($id) ?: $id = '';
    isset($name) ?: $name = '';
    isset($value) ?: $value = '';
    isset($class) ?: $class = '';
    isset($placeholder) ?: $placeholder = '';
    isset($size) ?: $size = 5;
    isset($search) ?: $search = false;
    isset($search_placeholder) ?: $search_placeholder = trans('manage::forms.button.search');
    isset($on_change) ?: $on_change = '';
    isset($extra) ?: $extra = '';
    isset($blank_label) ?: $blank_label = null;
    isset($options) ?: $options = [];
    isset($value_field) ?: $value_field = 'id';
    isset($caption_field) ?: $caption_field = 'title';
    isset($top_label) ?: $top_label = false;
    isset($top_label_class) ?: $top_label_class = '';

    if(isset($blank_value) and $blank_value=='NO') {
    	$blank_value = null ;
	}

	if(is_array($options)) {
    	$sample = $options[0] ;
    	if(!isset($sample['id'])) {
    		$value_field = '0';
		}
    	if(!isset($sample['title'])) {
	        $caption_field = '1';
		}
	}

	?>



	{{--
	|--------------------------------------------------------------------------
	| HTML Element
	|--------------------------------------------------------------------------
	|
	--}}
	@if($top_label)
		<label for="{{$name}}" class="control-label text-gray {{$top_label_class}}">{{ $top_label }}...</label>
	@endif


	<select
			id="{{$id}}"
			name="{{$name}}"
			value="{{$value}}"
			class="form-control selectpicker {{$class}}"
			placeholder="{{$placeholder}}"
			data-size="{{$size}}"
			data-live-search="{{$search}}"
			data-live-search-placeholder="{{$search_placeholder}}..."
			onchange="{{$on_change}}"
			{{$extra}}
	>


		{{-- Blank Value -------------------------------}}


		@if(isset($blank_value))
			<option value="{{$blank_value}}"
					@if($value==$blank_value)
						selected
					@endif
			>{{ $blank_label }}</option>
		@endif


		{{-- Real Options -------------------------------}}
		@foreach($options as $option)
			<option value="{{$option[$value_field]}}"
					@if($value==$option[$value_field])
						selected
					@endif
			>{{$option[ $caption_field ]}}</option>
		@endforeach
	</select>



	{{--
	|--------------------------------------------------------------------------
	| Script
	|--------------------------------------------------------------------------
	| 
	--}}

{{--	@include("manage::forms.js" , [--}}{{-- @TODO: Remove this ridiculous block if nobody is using it.--}}
		{{--'commands' => [--}}
			{{--isset($on_change) and (!isset($initially_run_onchange) or $initially_run_onchange) ? [$on_change] : [],--}}
		{{--]--}}
	{{--])--}}
@endif