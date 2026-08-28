<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller; use App\Models\NewsletterSubscriber; use Illuminate\Http\Request;
class NewsletterSubscriberController extends Controller { public function store(Request $r){$d=$r->validate(['email'=>'required|email|max:180']);NewsletterSubscriber::updateOrCreate(['email'=>$d['email']],['active'=>true]);return back()->with('success','Subscribed successfully.');} }
