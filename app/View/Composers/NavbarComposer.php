<?php

namespace App\View\Composers;

use Illuminate\View\View;

class NavbarComposer {
    public function compose(View $view) : void{
        if(!auth()->check()){
            return;
        }

        $user = auth()->user();

        $notifications = $user->notifications()
            ->latest()
            ->take(10)
            ->get();

        $unreadCount = $user->unreadNotifications()
            ->count();

        $view->with([
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
        ]);
    }
}