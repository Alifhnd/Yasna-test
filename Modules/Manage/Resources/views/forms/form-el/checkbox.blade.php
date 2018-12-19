<?php
if(isset($value) and is_object($value))
    $value = $value->$name ;

if(!isset($disabled))
    $disabled = false ;
?>
@if(!isset($condition) or $condition)
    <div id="{{$id or ''}}-div" class="checkbox c-checkbox {{$div_class or ''}} {{ $disabled? 'text-grey' : '' }} " >
        <label title="{{ $title or '' }}" style="cursor:{{$disabled? 'no-drop' : ''}}">
            <input type="hidden" name="{{$name}}" value="0">
            {!! Form::checkbox($name , '1' , $value , [
                'id' => isset($id)? $id : '' ,
                'class' => isset($class)? $class : '' ,
                $disabled? 'disabled' : '' => 1 ,
            ]) !!}
            <span class="fa fa-check"></span>
            {{ $label or trans("validation.attributes.$name") }}
        </label>
    </div>
@endif