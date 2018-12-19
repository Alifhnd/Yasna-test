@extends('manage::layouts.template')

@section('content')
	@include("manage::widgets.toolbar" ,[
			'buttons' => [
					[
					'type' => "primary",
					'caption' => trans("notifier::general.add"),
					'icon' => "plus",
					'target' => "modal:" . route('notifier.channel.addUI'),
					'condition'=> dev()
					],
			],
			'title' => ""
		])

	<div role="tabpanel" id="notifier_setting" class="panel panel-transparent" dir="ltr">
		<!-- Nav tabs-->
		<ul role="tablist" class="nav nav-tabs nav-justified p0">
			@foreach($channels as $channel)
				@if(isset($channel['drivers']) and count($channel['drivers']))
					<li role="presentation" class="{{ ($loop->index === 0)? 'active' : "" }}">
						<a href="#{{ $channel['slug'] }}" aria-controls="{{ $channel['slug'] }}" role="tab"
						   data-toggle="tab" class="bb0" aria-expanded="true">
							{{ $channel['title'] }}
						</a>
					</li>
				@endif
			@endforeach
		</ul>
		<!-- Tab panes-->
		<div class="tab-content p0 bg-white">
			@foreach($channels as $channel)
				@if(isset($channel['drivers']) and count($channel['drivers']))
					@include('notifier::setting.channel.panel',[
						"drivers" => $channel['drivers'] ,
					])
				@endif
			@endforeach
		</div>
	</div>
@endsection
