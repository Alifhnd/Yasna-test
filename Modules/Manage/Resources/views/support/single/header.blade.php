<div class="panel panel-default">
    <div class="panel-body p-xl">
        <h3 class="mt0 mb-lg">
            {{ $ticket['title'] }}
        </h3>
        @php $flag_info = yasnaSupport()->getFlagInfo($ticket['flag']) @endphp
        {{--<span class="bg-red label pt0">{{ $tiket['flag'] }}</span>--}}
        @include('manage::widgets.grid-badge', [
            'text' => $flag_info['title'],
            'color' => $flag_info['color'],
            'icon'=> $flag_info['icon'],
            'condition' => !empty($flag_info),
        ])
    </div>
    <div class="panel-footer">

        <button class="btn btn-primary btn-sm mv-sm" onclick="$('#timeline_comment_box').scrollToView()">
            <i class="fa fa-reply"></i>
            {{ trans('manage::support.answer') }}
        </button>

    </div>
</div>
