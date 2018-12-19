<?php

if (isset($link)) {
    $target = $link;
}
if (!isset($target)) {
    $target   = 'javascript:void(0)';
    $on_click = '';
} elseif (str_contains($target, '(')) {
    $on_click = $target;
    $target   = 'javascript:void(0)';
} elseif (str_contains($target, 'modal:')) {
    $url   = '';
    $array = [];

    // get string after the `modal:`
    $url_string = substr($target, 6);

    // if string contains `http://` or `https://` it means the url is rendered by `route()` already
    if (preg_match('/^http[s]?\:\/\//', $url_string)) {
        $urlWithoutHttp = preg_replace('/^http[s]?\:/', '', $url_string);
        $array          = explode(':', $urlWithoutHttp);
        $url            = $array[0];
    } else {
        // else it's a classic url
        $array = explode(':', $url_string);
        $url   = url($array[0]);
    }

    if (!isset($array[1])) {
        $array[1] = 'lg';
    }

    $on_click = "masterModal('" . $url . "' , '" . $array[1] . "' )";
    $target   = 'javascript:void(0)';
} else {
    $target = url($target);
}

?>

@if(!isset($condition) or $condition)
	<a id="{{$id or ''}}" href="{{$target}}" class="btn btn-{{$type or 'default'}} btn-sm {{$class or ''}}"
	   title="{{$caption or ''}}" onclick="{{$on_click or ''}}">
		<i class="fa fa-{{$icon or 'dot-circle-o'}}"></i>
		{{ $caption }}
	</a>
@endif
