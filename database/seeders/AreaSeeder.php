<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('areas')->insert([[
            'active'=>true,
            'name' => 'pasivos',
            'company_id' => 2,
            'department_id' => 1,
            'companyArea' => '2-pasivos'
        ]]);
    }
}
