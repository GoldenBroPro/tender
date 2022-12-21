<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\TmTenderStatus;

class TenderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ar_tender_status=[
            ["id"=>0,"name"=>"Удаленный","class_name"=>"danger"],
            ["id"=>1,"name"=>"Опубликовано","class_name"=>"primary"],
            ["id"=>2,"name"=>"Черновик","class_name"=>""],
            ["id"=>3,"name"=>"Закрыто","class_name"=>"danger"],
        ];

        foreach ($ar_tender_status as $tender_status) {
            TmTenderStatus::updateOrCreate([
                'id' => $tender_status['id']
            ],$tender_status);
        }
    }
}
