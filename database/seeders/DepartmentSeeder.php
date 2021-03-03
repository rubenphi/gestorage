<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([[
            'active' => true,
            'name' => 'contabilidad',
            'company_id' => 1,
            'companyDepartment' => '1-contabilidad'
        ]]);
    }
}
