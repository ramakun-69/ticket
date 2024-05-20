<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ResponseOutput;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileRequest;
use App\Repositories\Profile\ProfileRepository;
use App\Models\User;

class CProfile extends Controller
{
    Use ResponseOutput;
    protected $profileRepository;
    /**
     * Display a listing of the resource.
     */
    public function __construct(ProfileRepository $profileRepository) {
        $this->profileRepository = $profileRepository;
    }
    public function index()
    {
        $title = __("Profile");
        $user = Auth::user();
        return view("pages.profile.index", compact("title", "user"));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfileRequest $request, User $profile)
    {
        $update =   $this->profileRepository->updateProfile($request, $profile);
        return response()->json($update);
    }

    public function updatePicture(Request $request)
    {
        $user = Auth::user();
        $newProfilePicture = $request->file('foto');
        $response = $this->profileRepository->updateProfilePicture($user, $newProfilePicture);
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
