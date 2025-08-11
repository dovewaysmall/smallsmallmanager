<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $transactions = [];
        $transactionTypes = ['payment', 'deposit', 'rent', 'security_deposit'];
        $statuses = ['completed', 'pending', 'failed'];

        // Create transactions for the first 120 users (tenants)
        for ($i = 1; $i <= 120; $i++) {
            // Get user's creation date
            $userCreatedAt = DB::table('user_tbl')->where('userID', $i)->value('created_at');
            $transactionDate = Carbon::parse($userCreatedAt)->addDays(rand(0, 10));

            // Each tenant gets 1-3 transactions
            $numTransactions = rand(1, 3);
            
            for ($t = 1; $t <= $numTransactions; $t++) {
                $transactions[] = [
                    'userID' => $i,
                    'user_firstName' => 'User' . $i,
                    'user_lastName' => 'Test',
                    'transaction_type' => $transactionTypes[array_rand($transactionTypes)],
                    'type' => $transactionTypes[array_rand($transactionTypes)],
                    'amount' => rand(100000, 1000000), // 100k to 1M naira
                    'status' => $statuses[array_rand($statuses)],
                    'transaction_date' => $transactionDate->copy()->addDays(rand(0, $t * 30)),
                    'date' => $transactionDate->copy()->addDays(rand(0, $t * 30)),
                    'created_at' => $transactionDate,
                    'updated_at' => $transactionDate,
                ];
            }
        }

        // Insert transactions in batches
        $chunks = array_chunk($transactions, 50);
        foreach ($chunks as $chunk) {
            DB::table('transactions')->insertOrIgnore($chunk);
        }

        $this->command->info('Created ' . count($transactions) . ' transactions for tenant users');
    }
}