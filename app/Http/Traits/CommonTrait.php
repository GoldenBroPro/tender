<?php
namespace App\Http\Traits;
use App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

trait CommonTrait
{

    // ====================================
    //      Уникальный ID Тендоров
    // ====================================

    public function common_generate_next_tender_no($pre_no)
    {
        if($pre_no){
            $string = preg_replace("/[^0-9\.]/", '', $pre_no);
            return 'T' . sprintf('%06d', $string+1);
        }else{
            return "T000001";
        }
    }

    // ====================================
    //      Уникальный ID Заявок
    // ====================================

    public function common_generate_next_offer_no($pre_no)
    {
        if($pre_no){
            $string = preg_replace("/[^0-9\.]/", '', $pre_no);
            return 'B' . sprintf('%06d', $string+1);
        }else{
            return "B000001";
        }
    }

}
