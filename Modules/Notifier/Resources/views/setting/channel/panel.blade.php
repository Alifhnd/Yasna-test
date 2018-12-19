{{--
 ATTTENTION: class "tab-pane" is a mistake made by Developers of the template.
 	Do NOT fix it. Otherwise tabs wouldn't work.
 --}}
<div id="{{ $channel['slug'] }}" role="tabpanel" class="tab-pane {{ ($loop->index === 0)? 'active' : "" }}">
	{!!
	    widget('form-open')
	    ->target(route('notifier.driver.save.info'))
	    ->class('js')
	!!}


	<div class="pv-xl">
		<div class="panel-cols">
			@include('notifier::setting.form.radio',[
				"name" => 'default_driver' ,
				"value" => $channel['slug'].": " ,
				"label" => trans('notifier::general.no_driver') ,
				"is_checked" => true ,
			])
		</div>
	</div>
	<hr>
	@foreach($drivers as $driver)
		<div class="pv-xl">
			<div class="panel-cols">
				<div class="panel-col">
					@include('notifier::setting.form.radio',[
						"name" => 'default_driver' ,
						"value" => $driver['slug'] ,
						"label" => $driver['title'] ,
						"is_checked" => $channel['default_driver'] == (explode(":",$driver['slug'])[1]) ,
					])
				</div>
				<div class="panel-col-2">
					@foreach($driver['inputs'] as $key => $value)
						@include('notifier::setting.form.input',[
							"label" => $key ,
							"name" 	=> "data[".$driver['id']."]"."[$key]",
							"value" => $value ,
						])
					@endforeach
					<div class="panel-cols">
						{!!
							widget('toggle')
							->label('tr:notifier::general.view_admin')
							->name("data[".$driver['id']."]" . "[show-admin]")
							->value($driver['available_for_admins'])
						!!}
					</div>
					@if(dev())
						<div class="panel-cols" style="margin-top: 15px">
							<button class="btn btn-primary pull-right btn-lg" type="button"
									onclick="masterModal('{{route('notifier.driver.editUI',['id'=>$driver['id']])}}')">
								{{ trans('notifier::general.edit-driver')." ".$driver['title'] }}
							</button>

							<button class="btn btn-danger pull-right btn-lg mr" type="button"
									onclick="masterModal('{{route('notifier.driver.deleteUI',['id'=>$driver['id']])}}')">
								{{ trans('notifier::general.delete-driver')." ".$driver['title'] }}
							</button>
						</div>
					@endif
				</div>
			</div>
		</div>
		@if($loop->iteration !== $loop->count)
			<hr>
		@endif


	@endforeach


	<div class="panel-footer clearfix">

		<div class="panel-cols">

			<button class="btn btn-success btn-lg" type="submit">
				{{ trans('notifier::general.save')." ".$channel['title'] }}
			</button>

			@if(dev())
				<button class="btn btn-primary btn-lg mr" type="button"
						onclick="masterModal('{{route('notifier.channel.editUI',['id'=>$channel['slug']])}}')">
					{{ trans('notifier::general.edit-channel') }}
				</button>

				<button class="btn btn-danger pull-right btn-lg mr" type="button"
						onclick="masterModal('{{route('notifier.channel.deleteUI',['name'=>$channel['slug']])}}')">
					{{ trans('notifier::general.delete-channel')}}
				</button>
			@endif
		</div>


	</div>

	{!! widget('feed') !!}
	{!!
	    widget('form-close')
	 !!}
</div>
