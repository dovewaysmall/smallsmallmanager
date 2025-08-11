<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [];
        $now = Carbon::now();
        $startOfYear = Carbon::now()->startOfYear();
        $startOfMonth = Carbon::now()->startOfMonth();
        $startOfWeek = Carbon::now()->startOfWeek();

        // Generate 200 users for this year
        for ($i = 1; $i <= 200; $i++) {
            // Determine creation date
            if ($i <= 40) {
                // First 40 users are from this month
                if ($i <= 7) {
                    // First 7 users from this week
                    $createdAt = Carbon::createFromTimestamp(
                        rand($startOfWeek->timestamp, $now->timestamp)
                    );
                } else {
                    // Remaining 33 users from this month
                    $createdAt = Carbon::createFromTimestamp(
                        rand($startOfMonth->timestamp, $now->timestamp)
                    );
                }
            } else {
                // Remaining 160 users from earlier this year
                $createdAt = Carbon::createFromTimestamp(
                    rand($startOfYear->timestamp, $startOfMonth->subSecond()->timestamp)
                );
            }

            $users[] = [
                'userID' => $i,
                'first_name' => 'User' . $i,
                'last_name' => 'Test',
                'user_firstName' => 'User' . $i,
                'user_lastName' => 'Test',
                'email' => 'user' . $i . '@smallsmall.com',
                'phone' => '080' . str_pad($i, 8, '0', STR_PAD_LEFT),
                'password' => Hash::make('password123'),
                'status' => 'active',
                'user_type' => $i <= 120 ? 'tenant' : 'user', // First 120 are tenants
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ];
        }

        // Insert users in batches
        $chunks = array_chunk($users, 50);
        foreach ($chunks as $chunk) {
            DB::table('user_tbl')->insert($chunk);
        }

        $this->command->info('Created 200 users: 40 from this month, 160 from earlier this year');
        $this->command->info('120 users are marked as tenants');
    }
}