<?php

namespace App\Http\Controllers\ClientController;
use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\ClientRequest\Profile\UpdateProfileRequest;
use Inertia\Inertia;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

       $orders = Order::withCount('orderItems')
        ->where('user_id', Auth::id())
        ->latest()
        ->get();


        $user = Auth::user()->load('profile'); // Load profile relationship

        return Inertia::render('client_pages/Profile', [
            'orders' => $orders,
            'user' => $user,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProfileRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
        public function update(UpdateProfileRequest $request, Profile $profile)
        {

            
            $user = Auth::user();

            // Update user's basic info
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                // Store in 'profile' folder inside 'public' disk
                $avatarPath = $request->file('avatar')->store('profile', 'public');

                // Delete old avatar if exists
                if ($user->profile->avatar && Storage::disk('public')->exists($user->profile->avatar)) {
                    Storage::disk('public')->delete($user->profile->avatar);
                }

                $user->profile->avatar = $avatarPath;
            }


            // Update profile data with validated request input
            $user->profile->fill([
                'phone' => $request->phone,
                'address' => $request->address,
                'gender' => $request->gender,
                'dob' => $request->dob,
                'bio' => $request->bio,
            ])->save();

            return back()->with('success', 'Profile updated successfully!');
        }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
