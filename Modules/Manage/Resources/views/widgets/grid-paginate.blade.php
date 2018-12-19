<div class="paginate">
    @if(method_exists($models , 'render'))
        {!! $models->render() !!}
    @endif
</div>
