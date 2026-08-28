<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller; use App\Models\ContactMessage;
class ContactMessageController extends Controller { public function index(){return view('admin.messages.index',['messages'=>ContactMessage::latest()->paginate(25)]);} public function read(ContactMessage $message){$message->update(['is_read'=>true]);return back();} public function destroy(ContactMessage $message){$message->delete();return back()->with('success','Message deleted.');} }
