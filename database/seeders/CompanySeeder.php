<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->insert([[
            'active'=> true,
            'name'=> 'Laboratorio Nervocalm'
        ],[
            'active'=> true,
            'name' => 'Almacén Don Manolo'
        ]
            ]);

    }
}
