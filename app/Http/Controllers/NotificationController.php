<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
  public function index()
  {
    $user = Auth::user();
    $notifications = Notification::where('user_id', $user->id)
      ->latest()
      ->get()
      ->map(function ($notification) {
        return [
          'id' => $notification->id,
          'type' => $notification->type,
          'message' => $notification->message,
          'data' => $notification->data,
          'read' => $notification->read,
          'created_at' => $notification->created_at->format('Y-m-d H:i:s'),
        ];
      });

    $unreadCount = Notification::where('user_id', $user->id)
      ->where('read', false)
      ->count();

    return response()->json([
      'notifications' => $notifications,
      'unread_count' => $unreadCount,
    ]);
  }

  public function count()
  {
    $user = Auth::user();
    $count = Notification::where('user_id', $user->id)
      ->where('read', false)
      ->count();

    return response()->json(['count' => $count]);
  }

  public function markAsRead($id)
  {
    $user = Auth::user();
    $notification = Notification::where('user_id', $user->id)
      ->where('id', $id)
      ->firstOrFail();

    $notification->update(['read' => true]);

    return response()->json(['success' => true]);
  }
}