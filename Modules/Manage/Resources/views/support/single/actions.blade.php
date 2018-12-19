<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">عملیات</h3>
    </div>
    <div class="panel-body">

        <button class="btn btn-primary m5" onclick="goToCommentBox()">
            <i class="fa fa-reply"></i>
            {{ trans('manage::general.answer') }}
        </button>

        <br>

        <div class="dropdown inline m5">
            <button type="button" class="btn btn-info" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-building"></i>
                {{ trans('manage::general.change_department') }}
                <span class="caret ml"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                @foreach($departments as $department)
                    <li>
                        <a href="{{ $department['link'] }}">{{ $department['title'] }}</a>
                    </li>
                @endforeach
            </ul>
        </div>

        <br>

        <div class="dropdown inline m5">
            <button type="button" class="btn btn-info" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-sort-amount-up"></i>
                {{ trans('manage::general.change_priority') }}
                <span class="caret ml"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                @foreach($priorities as $priority)
                    <li>
                        <a href="{{ $priority['link'] }}">
                            {{ $priority['title'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <br>

        <button class="btn btn-green m5">
            <i class="fa fa-bookmark"></i>
            {{ trans('manage::general.mark_as_unread') }}
        </button>

        @if($ticket_status === "open")
            <button class="btn btn-danger m5">
                <i class="fa fa-ban"></i>
                {{ trans('manage::general.close_ticket') }}
            </button>
        @elseif($ticket_status === "close")
            <button class="btn btn-success m5">
                <i class="fa fa-unlock"></i>
                {{ trans('manage::general.open_ticket') }}
            </button>
        @endif

    </div>
</div>
