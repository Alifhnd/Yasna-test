<div id="{{ $container_id }}" class="form-feed alert {{ $container_class }}" style="display:none ; {{ $container_style }}">
	{{ trans('manage::forms.feed.wait') }}
</div>
<div class="d-n hide">
        <span class=" form-feed-wait" style="color: black;">
            <div style="width: 100%; text-align: center;">
                {{ trans('manage::forms.feed.wait')  }}
            </div>
        </span>
	<span class=" form-feed-error">{{ trans('manage::forms.feed.error') }}</span>
	<span class=" form-feed-ok">{{ trans('manage::forms.feed.done') }}</span>
</div>
