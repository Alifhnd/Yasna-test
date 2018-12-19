<?php namespace Modules\Manage\Http\Controllers;

use Modules\Manage\Http\Requests\ManageAddWidgetRequest;
use Modules\Yasna\Services\YasnaController;
use phpDocumentor\Reflection\Types\Array_;

class WidgetsController extends YasnaController
{
    protected $base_model = "User";



    /**
     * Refresh Widgets inner content
     *
     * @param $key
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function refreshWidget($key)
    {
        module('manage')->service('widgets_handler')->handle();
        $widget = module('manage')->service('widgets')->find($key)->get();

        return view($widget['blade'], compact('widget'));
    }



    /**
     * Refresh Widget repository
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function refreshWidgetSetting()
    {
        $widgets = $this->dashboardUnusedWidgets();

        return view("manage::layouts.off-sidebar.widget-setting", [
             "options" => $widgets,
             "view"    => true,
        ]);
    }



    /**
     * Add new widget from repository to dashboard
     *
     * @param ManageAddWidgetRequest $request
     *
     * @return string
     */
    public function addWidget(ManageAddWidgetRequest $request)
    {
        $saved_widgets = $this->dashboardSavedWidgets();

        $new_widgets = [
             "id" => "divWidget-$request->widget",
        ];


        $saved_widgets[] = $new_widgets;

        $ok = user()->setPreference('admin_widgets_order', json_encode($saved_widgets));

        return $this->jsonAjaxSaveFeedback($ok, [
             'success_callback' => "divReload('widgetsContainer');
				                        divReload('widgetSettingContainer');
				                        $('#btnWidgetsSaved').click();",
        ]);
    }



    /**
     * Save widgets new order and position
     *
     * @param $order
     *
     * @return string
     */
    public function saveWidgetsOrder($order)
    {
        return strval(user()->setPreference('admin_widgets_order', $order));
    }



    /**
     * Refreshes widgets container
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function refreshColumn()
    {
        return view('manage::index.widgets');
    }



    /**
     * displays widgets repository
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function widgetRepository()
    {
        $widgets   = $this->dashboardUnusedWidgets();
        $id_prefix = 'divWidget-';

        return view('manage::index.repository', compact('widgets', 'id_prefix'));
    }



    /**
     * Removes widgets from dashboard
     *
     * @param $key
     *
     * @return string
     */
    public function removeWidget($key)
    {
        $saved_widgets = $this->dashboardSavedWidgets();


        foreach ($saved_widgets as $i1 => $saved_widget) {
            if ($saved_widget['id'] == $key) {
                unset($saved_widgets[$i1]);
            }
        }
        $ok = strval(user()->setPreference('admin_widgets_order', json_encode($saved_widgets)));

        return $ok;
    }



    /**
     * returns unused widgets list
     *
     * @return array
     */
    public function dashboardUnusedWidgets()
    {
        $widgets = $this->dashboardAvailableWidgets();
        $saved   = $this->dashboardSavedWidgets();
        unset($saved['column-repository']);
        $id_prefix = 'divWidget-';

        foreach (array_flatten($saved) as $item) {
            $item = str_after($item, $id_prefix);
            if (isset($widgets[$item])) {
                unset($widgets[$item]);
            }
        }

        return $widgets;
    }



    /**
     * Dashboard unused widgets, with limited character number of captions.
     *
     * @return array
     */
    public function dashboardUnusedWidgetsForCombo()
    {
        $array = $this->dashboardUnusedWidgets();
        foreach ($array as $key => $widget) {
            $array[$key]['caption'] = str_limit($widget['caption'], 25);
        }

        return $array;
    }



    /**
     * returns all registered and available dashboard widgets
     *
     * @return array
     */
    public function dashboardAvailableWidgets()
    {
        module('manage')->service('widgets_handler')->handle();
        return module('manage')->service('widgets')->read();
    }



    /**
     * returns dashboard saved widgets
     *
     * @return array
     */
    public function dashboardSavedWidgets()
    {
        $value = user()->preference('admin_widgets_order');
        if (!$value) {
            $value = $this->defaultWidgets();
        }

        $array = (array)json_decode($value, 1);

        $newArray = $this->convertWidgetData($array) ?: $array;

        return $newArray;
    }



    /**
     * Converts old data type to new dashboard data
     *
     * @param $array
     *
     * @return array|bool
     */
    public function convertWidgetData($array)
    {
        $new_array = [];

        foreach ($array as $key => $item) {

            if ($this->isNewDataArray($key)) {
                continue;
            }

            foreach ($item as $id) {

                if (empty($id)) {
                    continue;
                }

                $new_array[] = $this->createWidgetArrayItem($id);
            }
        }

        return count($new_array) ? $new_array : false;
    }



    /**
     * Is of old widgets array type
     *
     * @param $key
     *
     * @return bool
     */
    public function isOldDataArray($key)
    {
        return !is_numeric($key);
    }



    /**
     * Is of new widgets array type
     *
     * @param $key
     *
     * @return bool
     */
    public function isNewDataArray($key)
    {
        return is_numeric($key);
    }



    /**
     * Create new widget array element with widget id
     *
     * @param $id
     *
     * @return array|bool
     */
    public function createWidgetArrayItem($id)
    {
        return [
             "id" => $id,
        ];
    }



    /**
     * Creates default widgets array from registered default widgets
     *
     * @return mixed
     */
    private function defaultWidgets()
    {
        $widgets = module('manage')->service('default_widgets')->read();
        $array   = $this->emptyWidgetsInstance();
        $id_prefix = "divWidget-";

        foreach ($widgets as $widget) {
            $array[] = [
                 "id" =>  $id_prefix . $widget['key'] ,
                 "width" => $widget['width'] ,
                 "x" => $widget['x'] ,
                 "y" => $widget['y'] ,
            ];
        }

        return json_encode($array);
    }



    /**
     * @return array
     */
    private function validPositions()
    {
        return [
             'column-big',
             'column-small',
             'column-even1',
             'column-even2',
        ];
    }



    /**
     * Generates a full dashboard widget collection, with empty cells
     *
     * @return array
     */
    private function emptyWidgetsInstance()
    {
        $array     = [];

        return $array;
    }
}
