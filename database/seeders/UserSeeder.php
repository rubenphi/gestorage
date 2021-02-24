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
        DB::table('users')->insert([
            [

                'first_name' => 'Rubén Darío',
                'last_name' => 'Villamil Zamora',
                'active' => true,
                'email' => 'rubenphii@gmail.com',
                'password' => Hash::make('1110535460'),


            ],
            [

            'first_name' => 'Manuel',
            'last_name' => 'Goreiro',
            'active' => true,
            'email' => 'manolito@manolos.com',
            'password' => Hash::make('rockefellerpapafrita'),


        ],
            [

                'first_name' => 'Felipe',
                'last_name' => 'Perez',
                'active' => true,
                'email' => 'felipe@manolos.com',
                'password' => Hash::make('felipezanahoria')

            ]
        ]);
        DB::table('company_user')->insert([[
            'company_id' => 1,
            'user_id' => 2,
            'active' => true,
            'rol' => 'admin',
            'companyUser' => '1-2'
        ],
            [
                'company_id' => 2,
                'user_id' => 2,
                'active' => true,
                'rol' => 'admin',
                'companyUser' => '2-2'
            ]
            ]);

        DB::table('area_user')->insert([[
            'area_id' => 1,
            'active' => true,
            'user_id' => 1,
            'rol' => 'admin',
            'areaUser' => '1-1'
        ],
            [
                'area_id' => 1,
                'active' => true,
                'user_id' => 2,
                'rol' => 'admin',
                'areaUser' => '1-2'
            ]]);

        DB::table('department_user')->insert([[
            'department_id' => 1,
            'user_id' => 1,
            'active' => true,
            'rol' => 'admin',
            'departmentUser' => '1-1'
        ],
            [
                'department_id' => 1,
                'user_id' => 2,
                'active' => true,
                'rol' => 'admin',
                'departmentUser' => '1-2'
            ]]);
    }
}
