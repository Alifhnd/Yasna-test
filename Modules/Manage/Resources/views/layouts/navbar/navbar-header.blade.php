<div class="navbar-header">
    <a href="/" class="navbar-brand">
        <div class="brand-logo">
                @include('manage::layouts.image',[
                    'src' => (isset($logoImgSrc) and $logoImgSrc) ? $logoImgSrc : Module::asset('manage:images/yasnateam-logo.png') ,
                    'alt'=>(isset($logoImgAlt) and $logoImgAlt) ? $logoImgAlt : "logo",
                    'class'=> "img-responsive"
                ])
        </div>
        <div class="brand-logo-collapsed">
            @include('manage::layouts.image',[
                    'src' =>(isset($collapsedLogoImgSrc) and $collapsedLogoImgSrc) ? $collapsedLogoImgSrc : Module::asset('manage:images/yasnateam-logo-small.png'),
                    'alt'=>(isset($collapsedLogoImgAlt) and $collapsedLogoImgAlt ) ? $collapsedLogoImgAlt: "logo",
                    'class'=> "img-responsive"
                ])
        </div>
    </a>
</div>