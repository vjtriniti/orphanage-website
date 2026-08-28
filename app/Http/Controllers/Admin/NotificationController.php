<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller; use Illuminate\Notifications\DatabaseNotification;
class NotificationController extends Controller { public function index(){return view('admin.notifications.index',['notifications'=>DatabaseNotification::where('notifiable_id',auth()->id())->latest()->paginate(30)]);} public function read(string $id){$n=DatabaseNotification::findOrFail($id);abort_unless($n->notifiable_id===auth()->id(),403);$n->markAsRead();return back();} }
