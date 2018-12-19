@foreach($models as $i => $model)
    @if(method_exists($model , 'spreadMeta'))
        @php
            $model->spreadMeta();
        @endphp
    @endif
    <tr id="tr-{{$model->hashid }}" class="grid {{ (method_exists($model , "isTrashed") and $model->isTrashed())? "deleted-content" : "" }}"
        @if(isset($handle) and str_contains($handle , 'selector'))
        ondblclick="gridSelector('tr','{{$model->hashid}}')"
         @endif
    >
        @include($row_view , ['model'=>$model])
    </tr>
@endforeach
