<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller; use App\Models\NewsletterSubscriber;
class NewsletterController extends Controller { public function index(){return view('admin.newsletter.index',['subscribers'=>NewsletterSubscriber::latest()->paginate(25)]);} public function destroy(NewsletterSubscriber $subscriber){$subscriber->update(['active'=>false]);return back()->with('success','Subscriber unsubscribed.');} }
