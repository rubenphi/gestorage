<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('requests')->insert([[
            'active'=>true,
            'name' => 'reclamo por falta se servicios',
            'expire' => date('Y-m-d H:i:s', strtotime('+ 24 hours')),
            'comments' => 'ninguno',
            'url' => 'ninguna',
            'response_address' => 'callefalsa123',
            'response_name' => 'pepito perez',
            'response_email' => 'pepito@gmail.com',
            'response_document' => '12357qw',
            'response_type' => 'correspondencia física',
            'status_id' => 1,
            'company_id' => 1,
            'from_area_id' => 1,
            'from_department_id' => 1,
            'to_area_id' => 1,
            'to_department_id' => 1,
            'type_id' => 1,
            'user_id' => 1,
            'created_at' => date('Y-m-d H:i:s')


        ]]);
    }
}
