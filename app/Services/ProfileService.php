<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Intl\Languages;

class ProfileService
{
    public function __construct(protected ProfileRepository $profileRepository) {}
    public function getEditData()
    {
        return [
            'user' => Auth::user(),
            'countries' => Countries::getNames(),
            'locales' => Languages::getNames()
        ];
    }
    public function destroy(Request $request)
    {
        Auth::logout();

        $this->profileRepository->delete($request->user());

        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}
