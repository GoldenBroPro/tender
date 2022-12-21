<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UmUserStatus;

class UserStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ar_user_status=[
            ["id"=>0,"name"=>"в ожидании"],
            ["id"=>1,"name"=>"активный"],
            ["id"=>2,"name"=>"заблокированный"]
        ];

        foreach ($ar_user_status as $user_status) {
            UmUserStatus::updateOrCreate([
                'id' => $user_status['id']
            ],$user_status);
        }


    }
}
