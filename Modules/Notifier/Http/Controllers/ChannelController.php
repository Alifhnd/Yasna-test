<?php

namespace Modules\Notifier\Http\Controllers;

use Modules\Notifier\Http\Requests\AddChannelRequest;
use Modules\Notifier\Http\Requests\EditChannelRequest;
use Modules\Notifier\Http\Requests\EditDriverRequest;
use Modules\Yasna\Http\Requests\SimpleYasnaRequest;
use Modules\Yasna\Services\YasnaController;

class ChannelController extends YasnaController
{

    /**
     * show add channel modal
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addUI()
    {
        return view('notifier::setting.channel.add');
    }



    /**
     * add new driver
     *
     * @param AddChannelRequest $request
     *
     * @return string
     */
    public function add(AddChannelRequest $request)
    {
        if (!dev()) {
            abort('403');
        }

        $is_saved = model('notifier')->batchSave([
             'slug'    => $request->channel . ":" . $request->driver_name,
             'channel' => $request->channel,
             'title'   => $request->driver_title,
             'driver'  => $request->driver_name,
             'data'    => $this->getFields($request->fields_name),
        ]);

        return $this->jsonAjaxSaveFeedback($is_saved, [
             'success_refresh' => '1',
             'success_message' => trans('notifier::general.feed-done'),
        ]);
    }



    /**
     * save info of channels driver
     *
     * @param SimpleYasnaRequest $request
     *
     * @return string
     */
    public function saveDriverInfo(SimpleYasnaRequest $request)
    {
        $is_saved = false;
        $is_saved = $this->setDefaultDriver($request->default_driver);
        foreach ($request->data as $key => $values) {
            $show_admin = ($values['show-admin']) ? 1 : 0;
            unset($values['show-admin']);
            $is_saved = model('notifier', $key)->batchSave([
                 'data'                 => $values,
                 'available_for_admins' => $show_admin,
            ]);
        }

        return $this->jsonAjaxSaveFeedback($is_saved, [
             'success_message' => trans('notifier::general.feed-done'),
        ]);
    }



    /**
     * show UI of edit driver
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editDriverUI($id)
    {
        $view_data['driver'] = model('notifier', $id);

        return view('notifier::setting.channel.edit_driver', $view_data);
    }



    /**
     * edit driver info
     *
     * @param EditDriverRequest $request
     *
     * @return string
     */
    public function editDriver(EditDriverRequest $request)
    {
        if (!dev()) {
            abort(403);
        }

        $obj = model('notifier', $request->id);

        $is_saved = $obj->batchSave([
             'slug'   => $obj->channel . ":" . $request->driver_name,
             'data'   => $this->getFields($request->fields_name, (array)$obj->getMeta('data')),
             'title'  => $request->driver_title,
             'driver' => $request->driver_name,
        ]);

        return $this->jsonAjaxSaveFeedback($is_saved, [
             'success_refresh' => '1',
             'success_message' => trans('notifier::general.feed-done'),
        ]);
    }



    /**
     * show driver delete UI
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function deleteDriverUI($id)
    {
        $view_data['driver'] = model('notifier', $id);

        return view('notifier::setting.channel.delete_driver', $view_data);
    }



    /**
     * delete driver
     *
     * @param SimpleYasnaRequest $request
     *
     * @return string
     */
    public function deleteDriver(SimpleYasnaRequest $request)
    {
        if (!dev()) {
            abort('403');
        }
        $is_del = model('notifier', $request->id)->delete();
        return $this->jsonAjaxSaveFeedback($is_del, [
             'success_refresh' => '1',
             'success_message' => trans('notifier::general.feed-done'),
        ]);
    }



    /**
     * show edit channel UI
     *
     * @param string $name
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editChannelUI($name)
    {
        return view('notifier::setting.channel.edit_channel', ['name' => $name]);
    }



    /**
     * edit channel name
     *
     * @param EditChannelRequest $request
     *
     * @return string
     */
    public function editChannel(EditChannelRequest $request)
    {
        $is_saved = true;
        if ($request->pre_name != $request->channel) {
            //TODO this must be done with single query loop is not good way
            foreach (model('notifier')->where('channel', $request->pre_name)->get() as $channel) {
                $channel->batchSave([
                     'slug'    => $request->channel . ":" . $channel->driver,
                     'channel' => $request->channel,
                ]);
            }
        }

        return $this->jsonAjaxSaveFeedback($is_saved, [
             'success_refresh' => '1',
             'success_message' => trans('notifier::general.feed-done'),
        ]);
    }



    /**
     * show channel delete UI
     *
     * @param string $name
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function deleteChannelUI($name)
    {
        return view('notifier::setting.channel.delete_channel', ['name' => $name]);
    }



    /**
     * delete a channel
     *
     * @param SimpleYasnaRequest $request
     *
     * @return string
     */
    public function deleteChannel(SimpleYasnaRequest $request)
    {
        if (!dev()) {
            abort('403');
        }
        $is_del = model('notifier')->where('channel', $request->name)->delete();

        return $this->jsonAjaxSaveFeedback($is_del, [
             'success_refresh' => '1',
             'success_message' => trans('notifier::general.feed-done'),
        ]);
    }



    /**
     * set default driver of channel
     *
     * @param string $default_driver
     *
     * @return bool
     */
    private function setDefaultDriver($default_driver)
    {
        $arr = explode(':', $default_driver);
        notifier()::setDefaultDriverOf($arr[0], $arr[1]);
        return true;
    }



    /**
     * get correct data style to save in driver list
     *
     * @param  string     $fields
     * @param  array|null $original_arr
     *
     * @return array
     */
    private function getFields($fields, $original_arr = null)
    {
        $arr  = explode(',', $fields);
        $data = [];
        foreach ($arr as $item) {
            $item_trimmed = trim($item);
            if (!isset($original_arr[$item_trimmed])) {
                $data[$item_trimmed] = null;
            } else {
                $data[$item_trimmed] = $original_arr[$item_trimmed];
            }
        }
        return $data;
    }

}
