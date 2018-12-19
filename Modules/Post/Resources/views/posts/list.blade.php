@extends('manage::layouts.template')
{{--@include('post::posts.tab')--}}
{{$page}}
@section('content')
    {!!
	widget('button')
	->label(trans('post::message.new_post'))
	->class('btn-outline')
	->shape('info')
	->condition(user()->isDeveloper())
	->onClick('masterModal("'. route('posts.create') .'")')
	!!}

	{!!
	widget('button')
	->label(trans('post::message.new_tag'))
	->class('btn-outline')
	->shape('info')
	->condition(user()->isDeveloper())
	->onClick('masterModal("'. route('tags.create') .'")')
	!!}


	@include("manage::widgets.grid" , [
	'table_id' => "tblPosts" ,
	'row_view' =>'post::posts.row' ,
	'handle' => "selector" ,
	'headings' => ["id","title" , "status"],
	'models' => $model,
]     )





	{{--<div class="card">--}}
        {{--<div class="card-title">--}}
            {{--<h4>{{trans('post::message.posts_list')}} </h4>--}}
        {{--</div>--}}
        {{--<div class="card-body">--}}
            {{--@include('partials.success')--}}
            {{--<div class="table-responsive">--}}
                {{--<table class="table">--}}
                    {{--<thead>--}}
                    {{--<tr>--}}
                        {{--<th>#</th>--}}
                        {{--<th>{{trans('post::message.title')}}</th>--}}
                        {{--<th>{{trans('post::message.author')}}</th>--}}
                        {{--<th>{{trans('post::message.add_created_at')}}</th>--}}
                        {{--<th>{{trans('post::message.status')}}</th>--}}
                        {{--<th>{{trans('post::message.operation')}}</th>--}}
                    {{--</tr>--}}
                    {{--</thead>--}}
                    {{--<tbody>--}}
                       {{--@foreach($posts as $post)--}}
                           {{--<tr>--}}
                               {{--<th scope="row">{{$post->post_id}}</th>--}}
                               {{--<td>{{$post->post_title}}</td>--}}
                               {{--<td>{{$post->post_author}}</td>--}}
                               {{--<td>{{$post->created_at}}</td>--}}
                               {{--<td>--}}
            {{--<span class="badge badge-{{$post->post_status == 1 ? 'success' : 'danger'}}">--}}
                {{--{{$post->post_status == 1 ?trans('post::message.active'): trans('post::message.inactive')}}--}}
            {{--</span>--}}
                               {{--</td>--}}
                               {{--<td>--}}
                                   {{--<a href="{{route('posts.delete' , [$post->id])}}">{{trans('post::message.delete')}}</a>--}}
                                   {{--<a href="{{route('posts.edit', [$post->id])}}">{{trans('post::message.edit')}}</a>--}}
                               {{--</td>--}}
                           {{--</tr>--}}
                           {{--@endforeach--}}
                    {{--</tbody>--}}
                {{--</table>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
@endsection
