<?php

namespace Database\Seeders;

use App\Models\Drink;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DrinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $drinks = [
            [
                'name' => 'Espresso',
                'type' => 'coffee',
                'price_tall' => 1.95,
                'price_grande' => 2.05,
                'price_venti' => 2.35,
            ],
            [
                'name' => 'Latte',
                'type' => 'coffee',
                'price_tall' => 3.40,
                'price_grande' => 4.45,
                'price_venti' => 4.65,
            ],
            [
                'name' => 'Cappuccino',
                'type' => 'coffee',
                'price_tall' => 3.15,
                'price_grande' => 3.75,
                'price_venti' => 4.15,
            ],
            [
                'name' => 'Green Tea',
                'type' => 'tea',
                'price_tall' => 3.45,
                'price_grande' => 4.25,
                'price_venti' => 4.45,
            ],
            [
                'name' => 'Hot Tea',
                'type' => 'tea',
                'price_tall' => 1.95,
                'price_grande' => null,
                'price_venti' => null,
            ],
        ];

        foreach ($drinks as $drink) {
            Drink::create($drink);
        }
    }
}
