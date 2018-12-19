@php
    if(isset($close) and $close){
        $closeClass = "alert-dismissible fade in";
    }

@endphp

<div role="alert" class="alert alert-{{ $type or "" }} {{ $closeClass or "" }}">
    @if(isset($close) and $close)
        <button type="button" data-dismiss="alert" aria-label="Close" class="close">
            <span aria-hidden="true">&times;</span>
        </button>
    @endif

    @if( isset($notice))
    <strong class="mr-sm">{{ $notice }}</strong>
    @endif
    {{ $massage }}
</div>