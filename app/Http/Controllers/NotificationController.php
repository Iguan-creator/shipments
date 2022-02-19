<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Get all notifications
     *
     * @return JsonResponse
     */
    public function getNotifications()
    {
        //TODO: turn on check and 7th user
        if (auth()->check() || true) {
            $user = Auth::user();
            $user = \App\Models\User::find(7);
            return jsonResponse(array_unique(array_merge(...$user->notifications->pluck('data')), SORT_REGULAR));
        }
    }

    /**
     * Clear all notifications
     *
     * @return string
     */
    public function clearNotifications()
    {
        if (auth()->check()) {
            $user = Auth::user();
            $user->notifications()->delete();

            return 'Success';
        }
    }
}
