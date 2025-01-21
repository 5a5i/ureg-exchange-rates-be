<?php

namespace Database\Seeders;

// use App\Models\User;
use App\Models\Currency;
use App\Models\Rate;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // $currencies = Currency::factory()->count(5)->create();

        // foreach ($currencies as $baseCurrency) {
        //     foreach ($currencies as $targetCurrency) {
        //         if ($baseCurrency->id !== $targetCurrency->id) {
        //             Rate::factory()->create([
        //                 'base_currency_id' => $baseCurrency->id,
        //                 'target_currency_id' => $targetCurrency->id,
        //             ]);
        //         }
        //     }
        // }

        $this->call([
            CurrencySeeder::class,
            RateSeeder::class,
            UserTableSeeder::class,
            // DeveloperSeeder::class,
        ]);
    }
}
