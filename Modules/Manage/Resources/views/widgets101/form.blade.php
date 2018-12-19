@if($target)
        <div class="tForms">

            {!! Form::open(array_merge([
                'id' => $id ,
                'url' => $target ,
                'method' => $method ,
                'files' => false ,
                'class' => ' form-horizontal ' . $class ,
                'style' => $style ,
                'no-validation' => intval(!$validation) ,
                'no-ajax' => intval(!$ajax) ,
                'onChange' => $on_change ,
            ], $extra_array)) !!}

            @if(isset($title))
                <div class="title">
                    {{$title}}...
                </div>
            @endif
@else
        {!! Form::close() !!}
        </div>
@endif
