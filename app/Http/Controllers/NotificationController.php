<?php

namespace App\Http\Controllers;
use Notific;
use DB;
use Auth;
class NotificationController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }
    /**
     * Make notification read
     *
     * @return ajax respone
     */
    public function notificationMakeRead($id){
        Notific::markNotificationRead( Auth::user()->id, $id );
        return response()->json($id,200);
    }
    public function notificationMore(){
        $notifications=$this->getNotification();
        // return $notifications;
        return view('admin.more-notification',compact('notifications'));
    }

    public function getNotification(){

        return Notific::getNotifications(Auth::user()->id, array('read_status' =>'all') );

    }
}
