<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clients')->insert([[
            'first_name' => 'Felipe',
            'last_name' => 'Geremias',
            'active' => true,
            'country' => 'Argentina',
            'region' => 'Pampeana',
            'city' => 'Buenos Aires',
            'document' => 'A3218947',
            'company_id' => 2,
            'address' => 'calle falsa 123',
            'email' => 'felipe@gmail.com',
            'companyDocument' => '2|A3218947'
        ]]);
    }
}
