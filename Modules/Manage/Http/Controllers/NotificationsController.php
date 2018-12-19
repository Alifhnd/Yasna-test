<?php

namespace Modules\Manage\Http\Controllers;

use Modules\Yasna\Http\Requests\SimpleYasnaRequest;
use Modules\Yasna\Services\YasnaController;

class NotificationsController extends YasnaController
{
    protected $view_folder = "manage::notifications";



    /**
     * Displays notifications list.
     *
     * @return \Illuminate\Support\Facades\View|\Symfony\Component\HttpFoundation\Response
     */
    public function list()
    {
        $notifications = user()
             ->notifications()
             ->paginate(50)
        ;
        $page          = $this->listPageInfo();

        return $this->view('main', compact('notifications', 'page'));
    }



    /**
     * Returns an array containing the page info for the list page.
     *
     * @return array
     */
    protected function listPageInfo()
    {
        return [
             [
                  str_after(route('notifications-list'), url('manage') . '/'),
                  $this->module()->getTrans('notifications.title'),
             ],
        ];
    }



    /**
     * Marks all notifications as read.
     *
     * @return int
     */
    public function markAll()
    {
        user()->unreadNotifications->markAsRead();

        return response()->json([
             'success' => true,
        ]);
    }



    /**
     * Renders the notification icon.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reloadIcon()
    {
        return view($this->module()->getBladePath('layouts.navbar.navbar-inner-right-notification'));
    }



    /**
     * Marks the specified notification as read.
     *
     * @param SimpleYasnaRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function markItem(SimpleYasnaRequest $request)
    {
        $notification = user()
             ->unreadNotifications()
             ->whereId($request->id)
             ->first()
        ;

        if (!$notification) {
            return response()->json([
                 'success' => false,
            ]);
        }

        $notification->markAsRead();
        return response()->json([
             'success' => $notification->read(),
        ]);
    }
}
