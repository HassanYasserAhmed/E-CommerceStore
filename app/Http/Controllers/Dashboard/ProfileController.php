<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UpdateProductRequest;
use ProfileRepository;
use ProfileService;

class ProfileController extends Controller
{
    public function __construct(
        protected ProfileRepository $profileRepository,
        protected ProfileService $profileService
    ) {}
    public function edit()
    {
        $data = $this->profileService->getEditData();

        return view('dashboard.profile.edite', $data);
    }

    public function update(UpdateProductRequest $request)
    {

        $this->profileRepository->update($request->user(), $request->validated());

        return redirect()->route('profile.edite')->with('success', 'Profile updated successfully');
    }
}
