<div class="radio ltr c-radio">
	<label>
		<input type="radio" name="{{ $name }}" value="{{ $value }}" @if(isset($is_checked) and $is_checked) checked @endif>
		<span class="fa fa-circle"></span>
		{{ $label }}
	</label>
</div>
