<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([[
            'name' => 'Manuel Goreiro',
            'first_name' => 'Manuel',
            'last_name' => 'Goreiro',
            'active' => true,
            'email' => 'manolito@manolos.com',
            'password' => Hash::make('rockefellerpapafrita')

        ],
            [
                'name' => 'Felipe Perez',
                'first_name' => 'Felipe',
                'last_name' => 'Perez',
                'active' => true,
                'email' => 'felipe@manolos.com',
                'password' => Hash::make('felipezanahoria')

            ]
        ]);
        DB::table('company_user')->insert([[
            'company_id' => 2,
            'user_id' => 1,
            'active' => true,
            'rol' => 'admin'
        ],
            [
                'company_id' => 2,
                'user_id' => 2,
                'active' => true,
                'rol' => 'admin'
            ]
            ]);

        DB::table('area_user')->insert([[
            'area_id' => 1,
            'active' => true,
            'user_id' => 1,
            'rol' => 'admin'
        ],
            [
                'area_id' => 1,
                'active' => true,
                'user_id' => 2,
                'rol' => 'admin'
            ]]);

        DB::table('department_user')->insert([[
            'department_id' => 1,
            'user_id' => 1,
            'active' => true,
            'rol' => 'admin'
        ],
            [
                'department_id' => 1,
                'user_id' => 1,
                'active' => true,
                'rol' => 'admin'
            ]]);
    }
}
