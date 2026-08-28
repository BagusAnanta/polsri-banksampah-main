<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class NotificationController extends Controller {

    public function notificationIndex(){
        $notifications = auth()->user()
            ->notifications()
            ->latest()
            ->paginate(20);
        
        return response()->json([
            'data' => $notifications->through(function ($notification){
                return [
                    'id' => $notification->id,
                    'title' => $notification->data['title'] ?? null,
                    'message' => $notification->data['message'] ?? null,
                    'type' => $notification->data['type'] ?? null,
                    'reference_id' => $notification->data['reference_id'] ?? null,
                    'read_at' => $notification->read_at,
                    'create_at' => $notification->create_at
                ];
            }),
        ]);
    }

    public function unreadCount(){
        $count = auth()->user()
            ->unreadNotifications()
            ->count();

        return response()->json([
            'unread_count' => $count
        ]);
    }

    public function markAsRead($id){
        $notification = auth()->user()
            ->notifications()
            ->findOrFail($id);

        $notification->markAsRead();

        return response()->json([
            'message' => 'Notifikasi sudah dibaca'
        ]);
    }

    public function markAllAsRead(){
        auth()->user()
            ->unreadNotifications
            ->markAsRead();

        return response()->json([
            'message' => 'Seluruh notifikasi sudah dibaca'
        ]);
    }


}