<?php

namespace App\Http\Controllers;

use App\Models\Volunteer;
use App\Models\VolunteerHour;
use Illuminate\Http\Request;

class VolunteerPortalController extends Controller
{
    public function index()
    {
        $volunteer = Volunteer::where('user_id', auth()->id())->first();
        if (!$volunteer) return redirect()->route('volunteer.apply');

        $hours = $volunteer->hours()->latest('started_at')->paginate(15);
        $total = $volunteer->hours()->whereNotNull('ended_at')->sum('hours');

        return view('volunteer.dashboard', compact('volunteer', 'hours', 'total'));
    }

    public function apply()
    {
        return view('volunteer.apply');
    }

    public function storeApplication(Request $request)
    {
        $data = $request->validate([
            'phone' => ['nullable', 'string', 'max:50'],
            'skills' => ['nullable', 'string', 'max:2000'],
            'experience' => ['nullable', 'string', 'max:5000'],
            'availability' => ['nullable', 'string', 'max:1000'],
            'emergency_contact' => ['nullable', 'string', 'max:255'],
        ]);

        $existing = Volunteer::where('user_id', auth()->id())->first();
        if ($existing) return redirect()->route('volunteer.dashboard');

        Volunteer::create(array_merge($data, [
            'user_id' => auth()->id(),
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'status' => 'pending',
        ]));

        return redirect()->route('volunteer.dashboard')->with('success', 'Volunteer application submitted for review.');
    }

    public function checkIn()
    {
        $volunteer = Volunteer::where('user_id', auth()->id())->where('status', 'approved')->firstOrFail();

        if ($volunteer->hours()->whereNull('ended_at')->exists()) {
            return back()->with('success', 'You already have an active session.');
        }

        $volunteer->hours()->create([
            'activity' => 'Volunteer session',
            'started_at' => now(),
        ]);

        return back()->with('success', 'Checked in successfully.');
    }

    public function checkOut(VolunteerHour $hour)
    {
        abort_unless($hour->volunteer && $hour->volunteer->user_id === auth()->id() && !$hour->ended_at, 403);

        $hour->ended_at = now();
        $hour->hours = round($hour->started_at->diffInMinutes($hour->ended_at) / 60, 2);
        $hour->save();

        return back()->with('success', 'Checked out successfully.');
    }
}
