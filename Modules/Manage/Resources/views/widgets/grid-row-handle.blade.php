@if(isset($refresh_url))
    <td class="refresh">{{ url($refresh_url) }}</td>
@endif
@if(isset($handle) and str_contains($handle , 'selector'))
    <td>
        {!!
            widget('checkbox')
            ->id("gridSelector-$model->hashid")
            ->setExtra('data-value',$model->hashid)
            ->class('gridSelector')
            ->onChange("gridSelector('selector','$model->hashid')")
         !!}
    </td>
@endif
@if(isset($handle) and str_contains($handle , 'counter'))
    <td class="-rowCounter">
        @if(isset($i))
            @pd($i+1)
        @endif
    </td>
@endif
<script>
    @if(method_exists($model , 'isTrashed') and $model->isTrashed())
         $("#tr-{{$model->hashid}}").addClass('deleted-content') ;
    @else
         $("#tr-{{$model->hashid}}").removeClass('deleted-content') ;
    @endif
</script>
