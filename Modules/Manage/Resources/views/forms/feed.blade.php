@if(!isset($condition) or $condition)
    <div class="form-feed alert {{ $div_class or '' }}" style="display:none">
        {{ $feed_wait or trans('manage::forms.feed.wait') }}
    </div>
    <div class="d-n hide">
        <span class=" form-feed-wait" style="color: black;">
            <div style="width: 100%; text-align: center;">
                {{  $feed_wait or trans('manage::forms.feed.wait')  }}
                {{--<br>--}}
                {{--<img src="{{ url('assets/site/images/64.gif') }}">--}}
            </div>
        </span>
        <div class="form-feed-error">
            <div class="{{ $danger_class or ""}}">
                {{ $feed_error or trans('manage::forms.feed.error') }}
            </div>
        </div>
        <div class="form-feed-ok">
            <div class="{{ $success_class or ""}}">
                {{ $feed_ok or trans('manage::forms.feed.done') }}
            </div>
        </div>
    </div>
@endif
