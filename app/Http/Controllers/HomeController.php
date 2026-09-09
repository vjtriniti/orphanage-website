<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Child;
use App\Models\Donation;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\Partner;
use App\Models\Post;
use App\Models\Testimonial;
use App\Models\Volunteer;

class HomeController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::where('status', 'active')->latest()->take(3)->get();
        $events = Event::where('published', true)->where('starts_at', '>=', now())->orderBy('starts_at')->take(3)->get();
        $posts = Post::where('status', 'published')->latest()->take(3)->get();
        $children = Child::where('active', true)->latest()->take(3)->get();
        $galleries = Gallery::with(['images' => fn ($query) => $query->where('published', true)->latest()])->latest()->take(1)->get();
        $testimonials = Testimonial::where('published', true)->latest()->take(3)->get();
        $partners = Partner::where('published', true)->orderBy('sort_order')->latest()->take(8)->get();

        $completedDonations = Donation::where('status', 'completed');
        $stats = [
            'children' => Child::where('active', true)->count(),
            'volunteers' => Volunteer::whereIn('status', ['approved', 'active'])->count(),
            'donations' => (float) $completedDonations->sum('amount'),
            'donors' => (clone $completedDonations)->whereNotNull('email')->distinct('email')->count('email'),
        ];

        return view('home', compact(
            'campaigns', 'events', 'posts', 'children', 'galleries', 'testimonials', 'partners', 'stats'
        ));
    }
}
