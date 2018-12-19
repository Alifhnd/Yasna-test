<?php

namespace Modules\Notifier\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class NotificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $this->markNotification($request);

        return $next($request);
    }



    /**
     * Marks the specified notification if needed.
     *
     * @param Request $request
     */
    protected function markNotification(Request $request)
    {
        $notification_id = $request->notification;
        if (!$notification_id) {
            return;
        }


        if (auth()->guest()) {
            return;
        }

        if (user()->not_exists) {
            return;
        }

        $notification = user()
             ->unreadNotifications()
             ->whereId($notification_id)
             ->first()
        ;

        if (!$notification) {
            return;
        }

        $notification->markAsRead();
    }
}
