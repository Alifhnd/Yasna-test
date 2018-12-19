@include('manage::layouts.modal-start' , [
'form_url' => route("posts.store"),
'modal_title' => trans_safe('post::message.new_post'),
])


	<div class='modal-body'>
		{!!
			widget('input')
			->name($name = 'postTitle')
			->inForm()
			->label(trans_safe('post::message.title'))
			->value($model->$name)
		!!}

		{!!
		widget('input')
		->name($name = 'postContent')
		->inForm()
		->label(trans_safe('post::message.content'))
		->value($model->$name)
		!!}

		{!!
		widget('combo')
		->name($name = 'postStatus')
		->options(model("post")::getStatusComboArray())
		->class('js-example-basic-multiple')
		->label(trans_safe('post::message.tags'))
		->inForm()
		!!}

		{!!
		widget('combo')
		->name($name = 'tag')
		->options(model("tag")->all())
		->class('js-example-basic-multiple')
		->label(trans_safe('post::message.tags'))
		->inForm()
		!!}

	</div>
<div class="modal-footer">
	@include('manage::forms.buttons-for-modal')
</div>








    {{--{!!--}}
		{{--widget('input')--}}
			{{--->name( 'title')--}}
			{{--->inForm()--}}
			{{--->class(['class'])--}}
			{{--->style(['style'])--}}
			{{--->label(trans('post::message.content'))--}}
			{{--->hint(['hint'])--}}
			{{--->extra(['extra'])--}}
			{{--->requiredIf(['is_required'])--}}
			{{--->value($model->$name)--}}
		{{--!!}--}}
    {{--{!!--}}
	   {{--widget('input')--}}
		   {{--->name($name = $item['field_name'])--}}
		   {{--->inForm()--}}
		   {{--->class($item['class'])--}}
		   {{--->style($item['style'])--}}
		   {{--->label($item['label'])--}}
		   {{--->hint($item['hint'])--}}
		   {{--->extra($item['extra'])--}}
		   {{--->requiredIf($item['is_required'])--}}
		   {{--->value($model->$name)--}}
	   {{--!!}--}}

    {{--<div class="card">--}}
        {{--<div class="card-title">--}}
            {{--<h4>ایجاد مطلب جدید </h4>--}}
        {{--</div>--}}
        {{--<div class="card-body">--}}
            {{--<div class="row">--}}
                {{--<div class="col-md-12">--}}
                    {{--<div class="basic-form p-10">--}}
                        {{--@include('partials.errors')--}}
                        {{--@include('partials.success')--}}

                        {{--<form method="post" action="{{route('posts.store')}}">--}}
                            {{--{{csrf_field()}}--}}
                            {{--<div class="form-group">--}}
                                {{--<label for="postTitle">{{trans('post::message.title')}}</label>--}}
                                {{--<input id="postTitle" name="postTitle" type="text"--}}
                                       {{--class="form-control input-default hasPersianPlaceHolder"--}}
                                       {{--value="{{old('postTitle')}}"--}}
                                {{-->--}}
                            {{--</div>--}}
                            {{--<div class="form-group">--}}
                                {{--<label for="postContent">{{trans('post::message.content')}}</label>--}}
                                {{--<textarea  id="postContent" name="postContent"--}}
                                       {{--class="form-control input-default "--}}

                                {{-->{{old('postContent')}}</textarea>--}}
                            {{--</div>--}}
                             {{--<div class="form-group">--}}
                                 {{--<label for="postTags">{{trans('post::message.tags')}}</label>--}}
                                 {{--<select multiple  style="width: 300px" name="postTags[]" id="postTags">--}}
                                     {{--@foreach($tags as $tag)--}}
                                         {{--<option value="{{$tag->id}}">{{$tag->title}}</option>--}}
                                         {{--@endforeach--}}

                                 {{--</select>--}}
                             {{--</div>--}}

                            {{--<div class="form-group">--}}
                                {{--<label for="postStatus">{{trans('post::message.status')}}</label>--}}
                                {{--<select name="postStatus" id="postStatus" class="form-control ">--}}
                                   {{--@foreach($statuses as $status => $statusTitle)--}}
                                        {{--<option value="{{$status}}">{{$statusTitle}}</option>--}}
                                    {{--@endforeach--}}
                                {{--</select>--}}
                            {{--</div>--}}
                            {{--<div class="form-group m-t-20">--}}
                                {{--<button type="submit" class="btn btn-primary m-b-10 m-l-5">{{trans('post::message.add')}}--}}
                                {{--</button>--}}
                            {{--</div>--}}
                        {{--</form>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
