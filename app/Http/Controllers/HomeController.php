<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Event;
use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::where('status', 'active')->latest()->take(3)->get();
        $events = Event::where('published', true)->where('starts_at', '>=', now())->orderBy('starts_at')->take(3)->get();
        $posts = Post::where('status', 'published')->latest()->take(3)->get();
        return view('home', compact('campaigns', 'events', 'posts'));
    }
}
