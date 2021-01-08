<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currencies')->insert([
            ['name' => 'EUR', 'created_at' => now()],
            ['name' => 'USD', 'created_at' => now()]
        ]);
        DB::table('delivery')->insert([
            ['city_id' => 1, 'value'=>50,'currency_id'=>1 , 'created_at' => now()],
            ['city_id' => 1, 'value'=>70,'currency_id'=>2 , 'created_at' => now()]
        ]);
        Order::factory()->count(9)->create();

        $exchange = 1.21; // Exchange rate $->€
        $prices = DB::table('prices')->pluck('product_id','value');
        foreach ($prices as $price => $id) {
            DB::table('prices')->insert([
                ['product_id'=>$id,'value'=> $price / $exchange ,'currency_id'=>1 , 'created_at' => now(),'updated_at' => now()]
            ]);
        }

    }
}
