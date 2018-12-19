@extends('manage::layouts.template')

@section('content')
	@include($__module->getBladePath('widgets.toolbar'), ['title' => $page[0][1]])

	<div class="tickets-timeline clearfix">

		<ul class="timeline">

			@include('manage::support.single.dialog-box',[
					"reversed" => false,
					"id" => "timeline_comment_box" ,
					"badge" => [
						"color" => "" ,
						"icon" => "plus" ,
					],
					"author" => '',
					"time" => "" ,
					"content" => [
						"type" => 'editor' ,
					],
					'form_action' => route('manage.support.save'),
					"badge_type" => "editor" ,
				])


		<!-- END timeline item-->
		</ul>

	</div>
@endsection
