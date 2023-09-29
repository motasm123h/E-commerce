<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function getNotifications(){
        $user = auth()->user();
        $notifications = $user->notifications;

        return response()->json([
            'notifications' => $notifications
        ]);
    }
    public function markNotificationsAsRead ($notificationId){

        $notification = auth()->user()->notifications()->findOrFail($notificationId);
        $sharedId = $notification->data['shared_id'];
        
        $users = User::where('role',1)->get();
        foreach($users as $user){
            $user->notifications()
            ->where('data->shared_id', $sharedId)
            ->get()
            ->markAsRead();
        }
        

        return response()->json([
            'message' => 'done'
        ]);
            

    }
    
    public function deleteNotification ($notificationId){
        
        $notification = auth()->user()->notifications()->findOrFail($notificationId);
        $sharedId = $notification->data['shared_id'];
        

        $users = User::where('role',1)->get();
        foreach($users as $user){
            $user->notifications()
            ->where('data->shared_id', $sharedId)
            ->delete();
        }

        return response()->json([
            'notifications' => 'done'
        ]);
    }


}
