<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $bookings = [];
        $properties = [
            'Lekki Phase 1 Apartment',
            'Victoria Island Condo',
            'Ikeja GRA House',
            'Ajah Waterfront Villa',
            'Surulere Duplex',
            'Yaba Student Lodge',
            'Ikoyi Luxury Tower',
            'Gbagada Estate Home',
            'Magodo Brooks Villa',
            'Festac Town Flat'
        ];

        // Create bookings for the first 120 users (tenants)
        for ($i = 1; $i <= 120; $i++) {
            // Get user's creation date to make booking around the same time
            $userCreatedAt = DB::table('user_tbl')->where('userID', $i)->value('created_at');
            $bookingDate = Carbon::parse($userCreatedAt)->addDays(rand(0, 7));

            $bookings[] = [
                'userID' => $i,
                'property_title' => $properties[array_rand($properties)],
                'current_property_title' => $properties[array_rand($properties)],
                'booking_status' => 'confirmed',
                'booking_date' => $bookingDate,
                'lease_start' => $bookingDate->copy()->addDays(rand(1, 30)),
                'lease_end' => $bookingDate->copy()->addMonths(rand(6, 24)),
                'amount' => rand(500000, 2000000), // 500k to 2M naira
                'created_at' => $bookingDate,
                'updated_at' => $bookingDate,
            ];
        }

        // Insert bookings in batches
        $chunks = array_chunk($bookings, 50);
        foreach ($chunks as $chunk) {
            DB::table('bookings')->insertOrIgnore($chunk);
        }

        $this->command->info('Created 120 bookings for tenant users');
    }
}