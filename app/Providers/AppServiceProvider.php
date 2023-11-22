<?php

namespace App\Providers;


use Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Notific;
use JoeDixon\Translation\Drivers\Translation;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Translation $translation)
    {
        \Illuminate\Support\Facades\Schema::defaultStringLength(191);


        Schema::defaultStringLength(191);

        \View::composer('*', function ($view) use ($translation) {
            if (auth()->check()) {
                $userId = auth()->user()->id;
                $countNotification = Notific::getNotificationCount($userId, 'all');
                $countUnreadNotification = Notific::getNotificationCount($userId, 'unread');
                $notifications = Notific::getNotifications($userId, array('read_status' => 'all', 'items_per_page' => 10));
                $notificationsData = array(
                    'countNotification' => $countNotification,
                    'countUnreadNotification' => $countUnreadNotification,
                    'notifications' => $notifications,

                );
                
                
                $view->with('notificationsData', $notificationsData);
            }
            $languages = $translation->allLanguages();
            $view->with('languages', $languages);
        });
    }
}
