@php
    $bodyColor = "";
    $innerColor = "bg-$color";

	if ($type ==="half" and isset($isDark) and  $isDark){
		$bodyColor = "bg-$color";
		$innerColor = "$bodyColor-dark";
	}

@endphp
<div id="{{ $id or "" }}" class="panel widget {{ $bodyColor }}">
        <div class="row row-table row-flush">
            @if($type=="full")
            <div class="col-xs-12">
                <div class="panel-body text-center {{ $innerColor or "" }}">
                    <h4 class="mt0">{{ $title or "" }}</h4>
                    <p class="mb0">{{ $text or "" }}</p>
                </div>
            </div>
            @elseif($type =="half")
                <div class="col-xs-4 {{ $innerColor or "" }} text-center">
                    <em class="fa fa-{{ $icon or "" }} fa-2x"></em>
                </div>
                <div class="col-xs-8">
                    <div class="panel-body text-center">
                        <h4 class="mt0">{{ $title or "" }}</h4>
                        <p class="mb0">{{ $text or "" }}</p>
                    </div>
                </div>
            @endif
        </div>
</div>