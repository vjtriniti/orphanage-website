<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DonorNotificationController extends Controller
{
    public function index()
    {
        $notifications = DB::table('notifications')->where('notifiable_type', get_class(auth()->user()))->where('notifiable_id', auth()->id())->latest()->paginate(20);
        return view('donor.notifications', compact('notifications'));
    }

    public function read(string $id)
    {
        DB::table('notifications')->where('id',$id)->where('notifiable_type',get_class(auth()->user()))->where('notifiable_id',auth()->id())->update(['read_at'=>now()]);
        return back();
    }
}
