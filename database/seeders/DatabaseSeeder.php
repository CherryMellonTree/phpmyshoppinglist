<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shop_items')->truncate();
        $faker = \Faker\Factory::create();
        $items = ['milk', 'eggs', 'butter', 'cheese', 'yoghurt', 'chicken', 'fish', 'tofu', 'potatoes', 'carrots', 'the souls of the innocent', 'liver', 'tomatoes', 'onions', 'garlic', 'sugar', 'apple', 'flour', 'baking powder', 'salt', 'pepper', 'basil', 'oregano', 'paprika', 'peas', 'pasta', 'rice'];
        for($i = 0; $i < 30; $i++){
            DB::table('shop_items')->insert([
                'itemName' => $items[array_rand($items, 1)],
                'itemDueDate' => $faker->iso8601($max = 'now'),
                'itemPreferedStoreID' =>  rand(1,5),
                'price' => rand(0,500)/100.0,
                'numberNeeded' => rand(1,20),
            ]);
        }
        DB::table('shops')->truncate();
        $names = ["AH", "Colruyt", "Aldi", "Lidl", "auctionhouse.stonks"];
        for($i = 0; $i < 5; $i++){
            DB::table('shops')->insert([
                'shopname' => $names[$i],
                'shopDistance' => rand(0,50)/10,
                'lastVisit' => $faker->iso8601($max = 'now')
            ]);
        }
    }
}