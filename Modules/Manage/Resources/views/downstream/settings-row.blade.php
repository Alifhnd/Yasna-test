{{--
---- this blade provides inputs of "panel-link-icon" blade
@var Setting Category
--}}

<div class="feature-item panel b js_setting-category">
    <div class="image-box">
        <img src="{{ Module::asset($category->manage_icon_url) }}" class="img-responsive">
    </div>
    <div class="content">
        <div class="p25">
            <h4 class="text-primary pb-lg">
                {{ $category->manage_category_title }}
            </h4>
            <div class="mv js_category-tags">
                @foreach($category->getSisters() as $sister)

                    @include('manage::widgets.grid-badge',[
                         "color" => "gray-light" ,
                         "text" => $sister->title ,
                         "icon" => false ,
                         "link" => "masterModal('$sister->manage_single_set_url')" ,
                    ])

                @endforeach
            </div>
            <div class="clearfix">
                <button class="btn btn-primary btn-taha pull-right" onclick="masterModal('{{ $category->manage_group_set_url }}')">
                    {{ trans('manage::settings.view_setting') }}
                </button>
            </div>
        </div>
    </div>

</div>
