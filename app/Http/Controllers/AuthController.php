<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

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
            Log::info('Attempting login for email: ' . $request->email);
            
            $response = Http::timeout(30)->post('http://api2.smallsmall.com/api/login', [
                'email' => $request->email,
                'password' => $request->password,
            ]);
            
            Log::info('Login response status: ' . $response->status());

            if ($response->successful()) {
                $data = $response->json();
                
                // Store user data in session
                Session::put('user_data', $data);
                Session::put('access_token', $data['token'] ?? null);
                
                return redirect()->route('dashboard');
            } else {
                $statusCode = $response->status();
                if ($statusCode === 401 || $statusCode === 422) {
                    return redirect()->back()->with('error', 'Invalid credentials. Please try again.');
                } elseif ($statusCode >= 500) {
                    return redirect()->back()->with('error', 'Server error. Please try again later.');
                } else {
                    return redirect()->back()->with('error', 'Login failed. Please try again.');
                }
            }
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('Connection error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to connect to the API server. The server may be down or under maintenance.');
        } catch (\Illuminate\Http\Client\RequestException $e) {
            Log::error('Request error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Request timeout. The server may be temporarily unavailable.');
        } catch (\Exception $e) {
            Log::error('Login error: ' . $e->getMessage() . ' | Class: ' . get_class($e));
            return redirect()->back()->with('error', 'Connection failed. The API server appears to be unresponsive.');
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