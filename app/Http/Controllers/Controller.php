<?php

namespace App\Http\Controllers;

abstract class Controller
{
    /**
     * Check if user is authenticated and redirect to login if not
     * 
     * @return \Illuminate\Http\RedirectResponse|null
     */
    protected function checkAuthentication()
    {
        $accessToken = session('access_token');
        if (!$accessToken) {
            session()->flush();
            return redirect()->route('login')->with('error', 'Session expired. Please login again.');
        }
        return null;
    }
}
