<?php

namespace Modules\Manage\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Yasna\Services\YasnaController;

class ManageController extends YasnaController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // Jquery Touch Punch
        module('manage')
             ->service('template_bottom_assets')
             ->add('jqueryui-touch-punch')
             ->link("manage:libs/vendor/jqueryui-touch-punch/jquery.ui.touch-punch.min.js")
             ->order(8)
        ;


        // Underscore
        module('manage')
             ->service('template_bottom_assets')
             ->add('underscore')
             ->link("manage:libs/vendor/underscore/underscore-min.js")
             ->order(9)
        ;

        // Gridstack
        module('manage')
             ->service('template_bottom_assets')
             ->add('gridstack')
             ->link("manage:libs/vendor/gridstack/gridstack.all.js")
             ->order(10)
        ;

        // Dashboard Widgets
        module('manage')
             ->service('template_bottom_assets')
             ->add('dashboard-widgets-js')
             ->link("manage:js/dashboard-widgets.min.js")
             ->order(42)
        ;

        return view('manage::index');
    }



    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function masterSearch(Request $request)
    {
        return view('manage::index', compact('request'));
    }



    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function graphDemo()
    {
        /*-----------------------------------------------
        | Related assets ...
        */


        /*-----------------------------------------------
        | Easy pie Chart ...
        */
        module('manage')
             ->service('template_bottom_assets')
             ->add()
             ->link("manage:libs/vendor/jquery.easy-pie-chart/dist/jquery.easypiechart.js")
             ->order(35)
        ;
        /*-----------------------------------------------
        |Chart.js ...
        */
        module('manage')
             ->service('template_bottom_assets')
             ->add()
             ->link("manage:libs/vendor/Chart.js/dist/Chart.js")
             ->order(35)
        ;
        /*-----------------------------------------------
        | Sparkline ...
        */
        module('manage')
             ->service('template_bottom_assets')
             ->add()
             ->link("manage:libs/vendor/sparkline/index.js")
             ->order(11)
        ;
        /*-----------------------------------------------
        | Flot Chart ...
        */
        /*        module('manage')
                  ->service('template_bottom_assets')
                  ->add()
                  ->link("manage:libs/vendor/flot/jquery.flot.js")
                  ->order(12)
               ;
               module('manage')
                  ->service('template_bottom_assets')
                  ->add()
                  ->link("manage:libs/vendor/flot.tooltip/js/jquery.flot.tooltip.min.js")
                  ->order(13)
               ;
               module('manage')
                  ->service('template_bottom_assets')
                  ->add()
                  ->link("manage:libs/vendor/flot/jquery.flot.resize.js")
                  ->order(14)
               ;
               module('manage')
                  ->service('template_bottom_assets')
                  ->add()
                  ->link("manage:libs/vendor/flot/jquery.flot.pie.js")
                  ->order(15)
               ;
               module('manage')
                  ->service('template_bottom_assets')
                  ->add()
                  ->link("manage:libs/vendor/flot/jquery.flot.time.js")
                  ->order(16)
               ;
               module('manage')
                  ->service('template_bottom_assets')
                  ->add()
                  ->link("manage:libs/vendor/flot/jquery.flot.categories.js")
                  ->order(17)
               ;
               module('manage')
                  ->service('template_bottom_assets')
                  ->add()
                  ->link("manage:libs/vendor/flot-spline/js/jquery.flot.spline.min.js")
                  ->order(18)
               ;*/
        //        module('manage')
        //            ->service('template_bottom_assets')
        //            ->add()
        //            ->link("manage:js/demo/demo-flot.js")
        //            ->order(18)
        //        ;
        /*-----------------------------------------------
          | Page Browse ...
          */

        $page = [
             '0' => ["graphs-demo", trans('manage::template.graphs')],
        ];
        return view('manage::graph-index', compact('page'));
    }



    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function elementsDemo()
    {
        /*-----------------------------------------------
        | Related assets ...
        */


        /*-----------------------------------------------
        | Trip.js ...
        */
        module('manage')
             ->service('template_bottom_assets')
             ->add()
             ->link("manage:libs/vendor/trip/trip.min.js")
             ->order(35)
        ;
        // Trip Style
        module('manage')
             ->service('template_assets')
             ->add()
             ->link("manage:libs/vendor/trip/trip.min.css")
             ->order(22)
        ;
        /*-----------------------------------------------
        | Nestable ...
        */
        module('manage')
             ->service('template_bottom_assets')
             ->add()
             ->link("manage:libs/vendor/nestable/jquery.nestable-rtl.js")
             ->order(35)
             ->condition(function (){
                 return isLangRtl();
             })
        ;
        module('manage')
             ->service('template_bottom_assets')
             ->add()
             ->link("manage:libs/vendor/nestable/jquery.nestable-ltr.js")
             ->order(35)
             ->condition(function (){
                 return isLangLtr();
             })
        ;
        /*-----------------------------------------------
          | Page Browse ...
          */
        $page = [
             '0' => ["elements-demo", trans('manage::template.elements')],
        ];
        return view('manage::elements-index', compact('page'));
    }



    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @deprecated (the new notification system doesn't need this system)
     */
    public function refreshAlerts()
    {
        return view("manage::layouts.navbar.navbar-alert");
    }



    /**
     * Top-bar Notifications
     */
    public static function handleNotification()
    {
        module('manage')
             ->service('nav_notification')
             ->add('manage')
             ->caption('نوتیف نمونه')
             ->condition(dev())
             ->link('modal:errors.m404')
             ->icon('user')
             ->color('warning')
             ->set('count', 0)
             ->comment('عنوان دوم')
        ;
        ;
    }
}
