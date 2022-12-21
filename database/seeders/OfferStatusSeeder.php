<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OmOfferStatus;

class OfferStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ar_offer_status=[
            ["id"=>0,"name"=>"В ожидании","class_name"=>"warning"],
            ["id"=>1,"name"=>"Одобренный","class_name"=>"primary"],
            ["id"=>2,"name"=>"Отклоненный","class_name"=>"danger"],
        ];

        foreach ($ar_offer_status as $offer_status) {
            OmOfferStatus::updateOrCreate([
                'id' => $offer_status['id']
            ],$offer_status);
        }
    }
}
