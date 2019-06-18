<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table('items')->insert([
            ['name' => '1 More E1001 Triple Driver IEM'],
            ['name' => '1 More E1001 Triple Driver IEM (Demo)'],
            ['name' => '1 More Piston Fit'],
            ['name' => 'ALO Litz MMCX 2.5'],
            ['name' => 'ATH-AR1iS'],
            ['name' => 'ATH-DSR7BT Black'],
            ['name' => 'ATH-LS50iS Black'],
            ['name' => 'ATH-LS70iS Black'],
        ]);
    }
}
