<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('statuses')->insert([
            [
                'name' => 'pendiente',
                'company_id' => 2
            ],
            [
                'name' => 'en proceso',
                'company_id' => 2
            ],
            [
                'name' => 'concluido',
                'company_id' => 2
            ]
        ]);
    }
}
