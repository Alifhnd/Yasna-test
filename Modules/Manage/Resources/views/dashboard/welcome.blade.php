<div class="img text-center m-xl">
    <img src="{{ asset('modules/manage/images/welcome-img.svg') }}" style="max-width: 300px; width: 100%;">
</div>

<div class="p-lg">

    <div class="font-yekan text-bold f20" style="color: #4f6a7b;">
        {{ trans_safe("manage::dashboard.welcome.line1") }}
    </div>

    <div class="tex-bold f18 text-pink text-purple mt-lg" style="color: #4f6a7b;">
        {{ trans_safe("manage::dashboard.welcome.introduction") }}
        <div class="text-center mvt30">
            {!!
            widget("button")
                ->id('start-tour')
                ->shape('purple')
                ->label('tr:manage::dashboard.welcome.start')
                ->class('btn-xl')
                ->style('padding:10px 20px; width: 100%; max-width: 280px;')
            !!}
        </div>
    </div>

</div>

{{--
|--------------------------------------------------------------------------
| Sctipt
|--------------------------------------------------------------------------
|
--}}
@include('manage::dashboard.welcome-trip')

@php
	module('manage')
		->service('template_bottom_assets')
		->add('manage-tour')
		->link("manage:libs/vendor/trip/trip.min.js")
		->order(201)
	;
	module('manage')
		->service('template_assets')
		->add()
		->link("manage:libs/vendor/trip/trip.min.css")
		->order(22)
	;
@endphp