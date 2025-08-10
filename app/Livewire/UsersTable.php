<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UsersTable extends Component
{
    public $users = [];
    public $loading = false;
    public $error = null;
    public $searchTerm = '';
    public $filteredUsers = [];

    public function mount()
    {
        // Initialize with empty arrays - user clicks to load
        $this->filteredUsers = [];
    }

    public function loadUsers()
    {
        try {
            $this->loading = true;
            $this->error = null;
            
            $accessToken = session('access_token');
            
            if (!$accessToken) {
                $this->error = 'Session expired. Please login again.';
                $this->loading = false;
                return;
            }
            
            $headers = [
                'Authorization' => "Bearer {$accessToken}",
                'Accept' => 'application/json',
            ];
            
            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/users');
            
            if ($response->successful()) {
                $apiData = $response->json();
                $this->users = $apiData['data'] ?? $apiData['users'] ?? $apiData ?? [];
                $this->filterUsers(); // Filter once after loading
            } elseif ($response->status() === 401) {
                $this->error = 'Session expired. Please login again.';
            } else {
                $this->error = 'Failed to load users. Please try again.';
            }
            
        } catch (\Exception $e) {
            Log::error('Users API Error: ' . $e->getMessage());
            $this->error = 'An error occurred while loading users.';
        } finally {
            $this->loading = false;
        }
    }

    public function updatedSearchTerm()
    {
        $this->filterUsers();
    }

    private function filterUsers()
    {
        if (empty($this->searchTerm)) {
            $this->filteredUsers = $this->users;
            return;
        }

        $searchTerm = strtolower($this->searchTerm);
        $this->filteredUsers = array_filter($this->users, function ($user) use ($searchTerm) {
            $name = strtolower(($user['firstName'] ?? '') . ' ' . ($user['lastName'] ?? ''));
            $email = strtolower($user['email'] ?? '');
            $phone = strtolower($user['phone'] ?? '');
            
            return str_contains($name, $searchTerm) ||
                   str_contains($email, $searchTerm) ||
                   str_contains($phone, $searchTerm);
        });
    }

    public function render()
    {
        return view('livewire.users-table');
    }
}
