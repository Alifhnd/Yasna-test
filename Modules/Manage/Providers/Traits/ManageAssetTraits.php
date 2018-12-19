<?php namespace Modules\Manage\Providers\Traits;

trait ManageAssetTraits
{
    /**
     * Manage Assets
     */
    public function registerAssets()
    {
        $this->registerJQueryAssets();
        $this->registerBootstrap();
        $this->registerBootstrapSelect();
        $this->registerBootstrapToggle();
        $this->registerBootstrapSlider();
        $this->registerFontAssets();
        $this->registerTinyMce();
        $this->registerWhirlAssets();
        $this->registerAnimationAssets();
        $this->registerAnimoAssets();
        $this->registerSBAdminAssets();
        $this->registerCalendarAssets();
        $this->registerCustomPanelTraits();
        $this->registerVueAssets();
        $this->registerModernizerAssets();
        $this->registerMatchMediaAssets();
        $this->registerSlimScrollAssets();
        $this->registerScreefullAssets();
        $this->registerMomentAssets();
        $this->registerPersianDatePicker();
        $this->registerMarkdownEditor();
        $this->registerSelectize();
        $this->registerWeatherWidget();
        $this->registerSupportAssets();
    }



    /**
     * Modernizer
     */
    private function registerModernizerAssets()
    {
        module('manage')
             ->service('template_bottom_assets')
             ->add('modernizr')
             ->link("manage:libs/vendor/modernizr/modernizr.custom.js")
             ->order(1)
        ;
    }



    /**
     * Match Media
     */
    private function registerMatchMediaAssets()
    {
        module('manage')
             ->service('template_bottom_assets')
             ->add('matchMedia')
             ->link("manage:libs/vendor/matchMedia/matchMedia.js")
             ->order(2)
        ;
    }



    /**
     * Animo JS
     */
    private function registerAnimoAssets()
    {
        module('manage')
             ->service('template_bottom_assets')
             ->add('animo-js')
             ->link("manage:libs/vendor/animo.js/animo.js")
             ->order(7)
        ;
    }



    /**
     * Slim Scroll
     */
    private function registerSlimScrollAssets()
    {
        module('manage')
             ->service('template_bottom_assets')
             ->add('slimscroll')
             ->link("manage:libs/vendor/slimScroll/jquery.slimscroll.min.js")
             ->order(8)
        ;
    }



    /**
     * Screenfull Plugin
     */
    private function registerScreefullAssets()
    {
        module('manage')
             ->service('template_bottom_assets')
             ->add('screenfull')
             ->link("manage:libs/vendor/screenfull/dist/screenfull.js")
             ->order(9)
        ;
    }



    /**
     * Moment with Locales
     */
    private function registerMomentAssets()
    {
        module('manage')
             ->service('template_bottom_assets')
             ->add('moment')
             ->link("manage:libs/vendor/moment/min/moment-with-locales.min.js")
             ->order(35)
        ;
    }



    /**
     * JQuery Javascript Assets (Header & Footer)
     */
    private function registerJQueryAssets()
    {
        module('manage')
             ->service('template_assets')
             ->add('jquery')
             ->link("manage:libs/jquery.min.js")
             ->order(1)
        ;
        module('manage')
             ->service('template_assets')
             ->add('jquery-form')
             ->link("manage:libs/jquery.form.min.js")
             ->order(2)
        ;
        module('manage')
             ->service('template_assets')
             ->add('jquery-input-mask')
             ->link("manage:libs/jquery.inputmask.bundle.js")
             ->order(3)
        ;
        module('manage')
             ->service('template_assets')
             ->add('jquery-ui')
             ->link("manage:libs/jquery-ui/jquery-ui.min.js")
             ->order(4)
        ;
        module('manage')
             ->service('template_bottom_assets')
             ->add('jquery-easing')
             ->link("manage:libs/vendor/jquery.easing/js/jquery.easing.js")
             ->order(6)
        ;
        module('manage')
             ->service('template_bottom_assets')
             ->add('jquery-storageApi')
             ->link("manage:libs/vendor/jQuery-Storage-API/jquery.storageapi.js")
             ->order(5)
        ;
    }



    /**
     * Font Files
     */
    private function registerFontAssets()
    {
        module('manage')
             ->service('template_assets')
             ->add('font-awesome')
             ->link("manage:libs/font-awesome/css/font-awesome.min.css")
             ->order(23)
        ;

        module('manage')
             ->service('template_assets')
             ->add('font-awesome-all')
             ->link("manage:libs/font-awesome-5.0.6/css/fontawesome-all.min.css")
             ->order(22)
        ;

        module('manage')
             ->service('template_assets')
             ->add('simple-line')
             ->link("manage:libs/vendor/simple-line-icons/css/simple-line-icons.css")
             ->order(24)
        ;
    }



    /**
     * TinyMCE WYSIWYG Editor (Header & Footer)
     */
    private function registerTinyMce()
    {
        module('manage')
             ->service('template_assets')
             ->add('tinyMCE')
             ->link("manage:libs/tinymce/tinymce.min.js")
             ->order(39)
        ;

        module('manage')
             ->service('template_bottom_assets')
             ->add('tinyMCE-starter')
             ->link("manage:libs/tinymce/tinymce.starter.js")
             ->order(100)
        ;
    }



    /**
     * Main Bootstrap Files (Header & Footer)
     */
    private function registerBootstrap()
    {
        module('manage')
             ->service('template_assets')
             ->add('bootstrap-rtl')
             ->link("manage:angle/css/bootstrap-rtl.css")
             ->order(7)
             ->condition(function (){
                 return isLangRtl();
             })
        ;

        module('manage')
             ->service('template_assets')
             ->add('bootstrap-ltr')
             ->link("manage:angle/css/bootstrap.css")
             ->order(7)
             ->condition(function (){
                 return isLangLtr();
             })
        ;

        module('manage')
             ->service('template_bottom_assets')
             ->add('bootstrap-js')
             ->link("manage:libs/vendor/bootstrap/dist/js/bootstrap.js")
             ->order(4)
        ;
    }



    /**
     * Bootstrap Select
     */
    private function registerBootstrapSelect()
    {
        module('manage')
             ->service('template_assets')
             ->add('bootstrap-select-css')
             ->link("manage:libs/bootstrap-select/bootstrap-select.min.css")
             ->order(8)
        ;

        module('manage')
             ->service('template_assets')
             ->add('bootstrap-select-js')
             ->link("manage:libs/bootstrap-select/bootstrap-select.min.js")
             ->order(11)
        ;

        module('manage')
             ->service('template_assets')
             ->add('bootstrap-select-trans')
             ->link("manage:libs/bootstrap-select/defaults-fa_IR.min.js")
             ->order(12)
             ->condition(function (){
                 return (getLocale() === "fa");
             })
        ;
    }



    /**
     * Bootstrap Toggle
     */
    private function registerBootstrapToggle()
    {
        module('manage')
             ->service('template_assets')
             ->add('bootstrap-toggle-css')
             ->link("manage:libs/bootstrap-toggle/bootstrap-toggle.min.css")
             ->order(9)
        ;
        module('manage')
             ->service('template_assets')
             ->add('bootstrap-toggle-js')
             ->link("manage:libs/bootstrap-toggle/bootstrap-toggle.min.js")
             ->order(10)
        ;
    }



    /**
     * Bootstrap Slider (Header & Footer)
     */
    private function registerBootstrapSlider()
    {
        module('manage')
             ->service('template_assets')
             ->add('bootstrap-slider-css')
             ->link("manage:libs/vendor/seiyria-bootstrap-slider/dist/css/bootstrap-slider.min.css")
             ->order(32)
        ;

        module('manage')
             ->service('template_bottom_assets')
             ->add('bootstrap-slider-js')
             ->link("manage:libs/vendor/seiyria-bootstrap-slider/dist/bootstrap-slider.min.js")
             ->order(30)
        ;
    }



    /**
     * Whirl Loaders CSS
     */
    private function registerWhirlAssets()
    {
        module('manage')
             ->service('template_assets')
             ->add('whirl')
             ->link("manage:libs/vendor/whirl/dist/whirl.css")
             ->order(21)
        ;
    }



    /**
     * Animate CSS
     */
    private function registerAnimationAssets()
    {
        module('manage')
             ->service('template_assets')
             ->add('animate')
             ->link("manage:libs/vendor/animate.css/animate.min.css")
             ->order(25)
        ;
    }



    /**
     * SB-Admin
     */
    private function registerSBAdminAssets()
    {
        module('manage')
             ->service('template_assets')
             ->add('metisMenu-js')
             ->link("manage:libs/sb-admin/metisMenu.js")
             ->order(31)
        ;

        module('manage')
             ->service('template_assets')
             ->add('sb-admin-js')
             ->link("manage:libs/sb-admin/sb-admin-2.js")
             ->order(31)
        ;
    }



    /**
     * Persian Calendar
     */
    private function registerCalendarAssets()
    {
        module('manage')
             ->service('template_assets')
             ->add('persian-calendar-css')
             ->link("manage:libs/datepicker/js-persian-cal.css")
             ->order(32)
        ;

        module('manage')
             ->service('template_assets')
             ->add('persian-calendar-js')
             ->link("manage:libs/datepicker/js-persian-cal.js")
             ->order(32)
        ;
    }



    /**
     * Custom Things Added to the Top
     */
    private function registerCustomPanelTraits()
    {
        module('manage')
             ->service('template_assets')
             ->add('manage-rtl-css')
             ->link("manage:css/manage-rtl.min.css")
             ->order(41)
             ->condition(function (){
                 return isLangRtl();
             })
        ;

        module('manage')
             ->service('template_assets')
             ->add('manage-ltr-css')
             ->link("manage:css/manage-ltr.min.css")
             ->order(41)
             ->condition(function (){
                 return isLangLtr();
             })
        ;

        module('manage')
             ->service('template_assets')
             ->add('app-rtl')
             ->link("manage:angle/css/app-rtl.css")
             ->order(43)
             ->condition(function (){
                 return isLangRtl();
             })
        ;

        module('manage')
             ->service('template_assets')
             ->add('app-ltr')
             ->link("manage:angle/css/app.css")
             ->order(43)
             ->condition(function (){
                 return isLangLtr();
             })
        ;

        module('manage')
             ->service('template_assets')
             ->add('admin-theme')
             ->link(function () {
                 $user = user();
                 if (!method_exists($user, 'adminTheme')) {
                     return false;
                 }

                 $theme = $user->adminTheme();
                 if ($theme) {
                     return "manage:angle/css/$theme.css";
                 } else {
                     return false;
                 }
             })
             ->order(44)
        ;
        module('manage')
             ->service('template_assets')
             ->add('forms-js')
             ->link("manage:js/forms.js")
             ->order(41)
        ;

        module('manage')
             ->service('template_assets')
             ->add('manage-js')
             ->link("manage:js/manage.js")
             ->order(42)
        ;

        module('manage')
             ->service('template_bottom_assets')
             ->add('app-js')
             ->link("manage:js/app.js")
             ->order(40)
        ;
        module('manage')
             ->service('template_bottom_assets')
             ->add('custom-js')
             ->link("manage:js/custom.js")
             ->order(41)
        ;
    }



    /**
     *  Persian DatePicker
     */
    public function registerPersianDatePicker()
    {
        // Css
        module('manage')
             ->service('template_assets')
             ->add('persian-datepicker-css')
             ->link("manage:libs/vendor/persian-datepicker/css/persian-datepicker.min.css")
             ->order(30)
        ;
        // JS | Persian Date
        module('manage')
             ->service('template_bottom_assets')
             ->add('persian-date-js')
             ->link("manage:libs/vendor/persian-datepicker/js/persian-date.min.js")
             ->order(36)
        ;
        // JS | Persian DatePicker
        module('manage')
             ->service('template_bottom_assets')
             ->add('persian-datepicker-js')
             ->link("manage:libs/vendor/persian-datepicker/js/persian-datepicker.min.js")
             ->order(37)
        ;
    }



    /**
     * Markdown Editor
     */
    public function registerMarkdownEditor()
    {
        // Marked
        module('manage')
             ->service('template_bottom_assets')
             ->add('md-editor-js')
             ->link("manage:libs/vendor/md-editor/marked.min.js")
             ->order(36)
        ;
        // Custom Css
        module('manage')
             ->service('template_assets')
             ->add('md-editor-css')
             ->link("manage:libs/vendor/md-editor/md-editor.css")
             ->order(30)
        ;
    }



    /**
     * VUE-JS :)
     */
    private function registerVueAssets()
    {
        module('manage')
             ->service('template_bottom_assets')
             ->add('vue-js')
             ->link("manage:libs/vuejs/vue.min.js")
             ->order(3)
        ;

        module('manage')
             ->service('template_bottom_assets')
             ->add('vue-color')
             ->link("manage:libs/vendor/vue-color/vue-color.min.js")
             ->order(30)
        ;
    }



    /**
     * add selectize widget
     */
    private function registerSelectize()
    {
        //js
        module('manage')
             ->service('template_bottom_assets')
             ->add('selectize')
             ->link("manage:libs/vendor/selectize/dist/js/standalone/selectize.js")
             ->order(38)
        ;

        //css
        module('manage')
             ->service('template_assets')
             ->add('selectize')
             ->link("manage:libs/vendor/selectize/dist/css/selectize.css")
             ->order(39)
        ;
        module('manage')
             ->service('template_assets')
             ->add('selectize')
             ->link("manage:libs/vendor/selectize/dist/css/selectize.default.css")
             ->order(40)
        ;
    }



    /**
     *  Weather Widget Assets
     */
    private function registerWeatherWidget()
    {
        // Weather Icon
        module('manage')
             ->service('template_assets')
             ->add('weather-icons')
             ->link("manage:libs/vendor/weather-icons/css/weather-icons.min.css")
             ->order(30)
        ;

        // Weather Icon
        module('manage')
             ->service('template_assets')
             ->add('weather-icons-wind')
             ->link("manage:libs/vendor/weather-icons/css/weather-icons-wind.min.css")
             ->order(31)
        ;

        // Skycon
        module('manage')
             ->service('template_bottom_assets')
             ->add('Skycons')
             ->link("manage:libs/vendor/skycons/skycons.js")
             ->order(38)
        ;
    }



    /**
     * Support Assets
     */
    private function registerSupportAssets()
    {
        // Support JS
        module('manage')
             ->service('template_assets')
             ->add('timer-js')
             ->link("manage:js/timer.min.js")
             ->order(15)
        ;

        // Support JS
        module('manage')
             ->service('template_assets')
             ->add('support-ja')
             ->link("manage:js/tickets.min.js")
             ->order(43)
        ;
    }
}
