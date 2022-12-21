<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Traits\CommonTrait;
use App\Models\OmOffer;
use App\Models\TmTender;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OfferController extends Controller
{
    use CommonTrait;



    // ====================================
    //       Просмотр заявки (юзер)
    // ====================================

    public function show_offer_create(Request $request,$tenderId){
        $userSession = $request->session()->get(config("global.session_user_obj"));
        $user_id = $userSession->id;

        $FoundOffer=OmOffer::where("vm_vendor_id",$user_id)->where("tm_tender_id",$tenderId);

        if($FoundOffer!==null && $FoundOffer->exists()){
            return redirect()->action([OfferController::class, 'show_offer'],["id"=>$FoundOffer->id]);
        }else{
            $Tender=TmTender::find($tenderId);
            return view('account.offer_create.index',compact('Tender'));
        }
    }


    // ====================================
    //       Просмотр заявки (юзер)
    // ====================================

    public function show_offer(Request $request,$id){
        $Offer = OmOffer::find($id);
        if($Offer!==null && $Offer->exists()){
            $userSession = $request->session()->get(config("global.session_user_obj"));
            $user_id = $userSession->id;
            if($Offer->vm_vendor_id===$user_id || $userSession->um_user_role_id===config("global.user_role_admin")){
                $Tender=TmTender::find($Offer->tm_tender_id);
                return view('account.offer_view.index',compact('Offer','Tender'));
            }else{
               return redirect()->back();
            }
        }else{
            return abort(404);
        }
    }


    // ====================================
    //       Просмотр заявки (юзер)
    // ====================================

    public function account_show_tender_offers($tenderId)
    {
        $Tender = TmTender::find($tenderId);
        if($Tender!==null){
            $TenderOffers = OmOffer::where("tm_tender_id",$tenderId)->simplePaginate(1);

            return view('account.tenders_offers_compare.index', compact('Tender','TenderOffers'));
        }else{
            return abort(404);
        }
    }


    // ========================================
    //     Вкладка: все заявки (юзер)
    // ========================================


    public function account_show_all_my_offers(Request $request)
    {
        $userSession = $request->session()->get(config("global.session_user_obj"));
        $user_id = $userSession->id;
        $Offers = OmOffer::where("vm_vendor_id",$user_id)->get();

        return view('account.my_offers.index', compact('Offers'));
    }

    // ========================================
    //     Вкладка: одобренные заявки (юзер)
    // ========================================

    public function account_show_all_my_approved_offers(Request $request)
    {
        $userSession = $request->session()->get(config("global.session_user_obj"));
        $user_id = $userSession->id;
        $Offers = OmOffer::where("vm_vendor_id",$user_id)->where("om_offer_status_id",config("global.offer_status_approved"))->get();
        return view('account.my_offers.index', compact('Offers'));
    }

    // ========================================
    //            форма подачи заявки
    // ========================================

    public function createOffer(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'bid_amount' => 'required|numeric',
                'period_years'=>'required|digits_between:0,20',
                'period_months'=>'required|digits_between:0,12',
                'tender_id'=>'required|exists:tm_tender,id',
                'note'=>'sometimes'
            ], [
                'bid_amount.required' => 'Требуется сумма ставки.',
                'tender_id.required' => 'Требуется тендерный идентификатор.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::beginTransaction();


        $userSession = $request->session()->get(config("global.session_user_obj"));
        $user_id = $userSession->id;

            $maxId = OmOffer::max("id");
            $offerId = $this->common_generate_next_offer_no($maxId);

            $years=$request->get("period_years");
            $months=$request->get("period_months");

            $period=($years>0?($years==1?"1 год ":$years." лет "):"")."".($months>0?($months===1?"1 месяц ":$months." месяцев "):"");

            $offer = OmOffer::create([
                'id' => $offerId,
                'bid_amount' => $request->get('bid_amount'),
                'period' => $period,
                'om_offer_status_id' => config("global.offer_status_pending"),
                'vm_vendor_id' => $user_id,
                'tm_tender_id'=>$request->get('tender_id'),
                'note'=>$request->get('note')
            ]);


            DB::commit();

            session()->flash('message', "Успешно подчинял вашу ставку");
            session()->flash('flash_message_type', config("global.flash_success"));
            return redirect()->action([TenderController::class, 'account_show_tender'],["tenderId"=>$request->get("tender_id")]);

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', $e->getMessage());
            session()->flash('flash_message_type', config("global.flash_error"));
            return redirect()->back();
        }
    }


    // ========================================
    //    Обновление статуса заявки ( Админ )
    // ========================================


    public function updateOfferStatus(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'tender_id'=>'required|exists:tm_tender,id',
                'offer_id'=>'required|exists:om_offer,id',
                'action'=>'required',
            ], [
                'tender_id.required' => 'Требуется тендерный идентификатор.',
                'offer_id.required' => 'Требуется идентификатор предложения.',
                'action.required' => 'Действие требуется.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::beginTransaction();

            $offer = OmOffer::where("id",$request->get("offer_id"))->where("tm_tender_id",$request->get("tender_id"))->first();
            if($offer!==null){
                if($request->get("action")===config("global.offer_status_action_approve")){
                    $offer->om_offer_status_id=config("global.offer_status_approved");
                }else if($request->get("action")===config("global.offer_status_action_reject")){
                    $offer->om_offer_status_id=config("global.offer_status_rejected");
                }else if($request->get("action")===config("global.offer_status_action_revert")){
                    $offer->om_offer_status_id=config("global.offer_status_pending");
                }else{
                    throw new Exception("Не могу найти действительное действие");
                }
                $offer->save();

                DB::commit();

                session()->flash('message', "успешно обновил статус");
                session()->flash('flash_message_type', config("global.flash_success"));
            }else{
                throw new Exception("Предложение недействительно");
            }
            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', $e->getMessage());
            session()->flash('flash_message_type', config("global.flash_error"));
            return redirect()->back();
        }
    }

}
