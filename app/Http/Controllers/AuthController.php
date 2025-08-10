<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        try {
            $response = Http::post('http://api2.smallsmall.com/api/login', [
                'email' => $request->email,
                'password' => $request->password,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // Store user data in session
                Session::put('user_data', $data);
                Session::put('access_token', $data['token'] ?? null);
                
                return redirect()->route('dashboard');
            } else {
                return redirect()->back()->with('error', 'Invalid credentials. Please try again.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Unable to connect to the server. Please try again later.');
        }
    }

    public function logout(Request $request)
    {
        try {
            Session::flush();
            return redirect()->route('login')->with('success', 'You have been logged out successfully.');
        } catch (\Exception $e) {
            // If there's any error (including CSRF), still flush and redirect
            Session::flush();
            return redirect()->route('login')->with('info', 'Session expired. Please login again.');
        }
    }
}