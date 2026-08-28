<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\ContactMessage;
class ContactController extends Controller { public function store(Request $request){$data=$request->validate(['name'=>'required|string|max:120','email'=>'required|email|max:160','subject'=>'required|string|max:180','message'=>'required|string|max:3000']); ContactMessage::create($data); return back()->with('success','Your message has been received.');} }
