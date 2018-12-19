<div class="user-block-picture">
    {{--@TODO: Read account setting dynamically--}}
    <a href="{{ url('/manage/account') }}">
        <div class="user-block-status">
            @include('manage::layouts.image',[
				'src'=> $src,
				'alt'=>"Avatar",
				'width'=>"60",
				'height'=>"60",
				'class'=>"img-thumbnail img-circle"
			])
            <div class="circle circle-success circle-lg"></div>
        </div>
    </a>
</div>