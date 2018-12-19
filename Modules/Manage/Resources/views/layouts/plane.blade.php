<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="fa" class="no-js">
<!--<![endif]-->

    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta charset="utf-8"/>

        <script language="javascript">
            function assets($additive) {
                if (!$additive) $additive = '';
                return url('assets/' + $additive);
            }
            function url($additive) {
                if (!$additive) $additive = '';
                return '{{ url('-additive-') }}'.replace('-additive-', $additive);
            }
            function hashid0() {
            	return '{{ hashid(0) }}' ;
            }
        </script>

        @include("manage::layouts.assets-top")

        <title>@yield('page_title')</title>
        @yield('html_header')

    </head>

    <body dir="{{ (isLangRtl())? 'rtl': 'ltr' }}">
        @yield('body')
        @yield('end-of-body') {{-- <~~ @Depreciated: Use "html_footer" instead. Please. --}}
        @yield('html_footer')

        <!-- End body scripts -->
        @include('manage::layouts.assets-bottom')
    </body>


</html>
