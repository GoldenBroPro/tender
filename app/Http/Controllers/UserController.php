<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Traits\UserTrait;
use App\Models\TmTender;
use App\Models\TmTenderCategory;
use App\Models\UmUser;
use App\Models\UmUserLogin;
use App\Models\VmVendor;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use UserTrait;

    public function show_home(Request $request,$category=0)
    {
        $categorries = TmTenderCategory::where('active', 1)->get();
        $tenders=TmTender::where('tm_tender_status_id', 1)->where("end_date", '>', Carbon::now());
        $SelectedCategory=null;
        if($category>0){
            $SelectedCategory=TmTenderCategory::find($category);
            $tenders=$tenders->where('tm_tender_category_id',$category)->get();
        }else{
            $tenders=$tenders->get();

        }
        return view('home.home', compact('categorries', 'tenders','SelectedCategory'));
    }





    public function show_UserManagement(Request $request)
    {
        $userSession = $request->session()->get(config("global.session_user_obj"));
        $userList = UmUser::where('id', '<>', $userSession->id)->get();
        return view('account.user_management.index', compact('userList'));
    }


    // ========================
    //      Профиль
    // ========================


    public function show_profile(Request $request)
    {
        $userSession = $request->session()->get(config("global.session_user_obj"));
        $userData = UmUser::find($userSession->id);
        return view('account.profile_update.index', compact('userData'));
    }



    // ========================
    //      Авторизация
    // ========================




    public function user_login(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'username' => 'required',
                'password' => 'required',
            ], [
                'username.required' => ':attribute поле, обязательное для заполнения.',
                'password.required' => ':attribute поле, обязательное для заполнения.',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $username = $request->get('username');
            $password = $request->get('password');

            $user_login_object = UmUserLogin::where("username", $username)->first();
            if (!$user_login_object) {
                throw new Exception("Не верная почта или пароль");
            } else {
                if (Hash::check($request->get('password'), $user_login_object->password)) {
                    $user_obj = UmUser::find($user_login_object->um_user_id);
                    if ($user_obj) {
                        if ($user_obj->um_user_status_id === config('global.user_status_active')) {
                            $user_permissions = $this->user_role_getUserRolePermissions($user_obj->um_user_role_id);
                            $user_permissions_tabs = $this->user_role_getUserRolePermissions_tabs($user_obj->um_user_role_id);
                            session([config("global.session_user_obj") => $user_obj, config("global.session_permissions") => json_encode($user_permissions), config("global.session_permissions_tabs") => json_encode($user_permissions_tabs)]);

                            return redirect('/');
                        } else {
                            throw new Exception("Ваша учетная запись была заблокирована, пожалуйста, свяжитесь с администратором");
                        }
                    } else {
                        throw new Exception("Пользователь не найден");
                    }
                } else {
                    throw new Exception("Неверный пароль");
                }
            }
        } catch (\Exception $e) {
            session()->flash('message', $e->getMessage());
            session()->flash('flash_message_type', config("global.flash_error"));
            return redirect()->back();
        }
    }

    public function user_logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }



    // ========================
    //      Регистрация
    // ========================



    public function user_registration(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'firstname' => 'required',
                'company_email' => 'required|email',
                'username' => 'required|email|unique:um_user_login,username',
                'password' => 'required|confirmed',
            ], [
                'firstname.required' => ':attribute поле, обязательное для заполнения.',
                'username.required' => ':attribute поле, обязательное для заполнения.',
                'password.required' => ':attribute поле, обязательное для заполнения.',
                'company_email.required' => ':attribute поле, обязательное для заполнения.',
                'username.email' => ':attribute Не действительная почта.',
                'username.unique' => ':attribute Уже зарегистрирован',
                'company_email.email' => ':attribute Не действительная почта.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::beginTransaction();
            $user_id = (UmUser::max('id') + 1);

            $user = UmUser::create([
                'id' => $user_id,
                'firstname' => $request->get('firstname'),
                'lastname' => $request->get('lastname'),
                'um_user_status_id' => config("global.user_status_active"),
                'um_user_role_id' => config("global.user_role_vendor"),
            ]);

            $user_login = UmUserLogin::create([
                'id' => $user_id,
                'username' => $request->get('username'),
                'password' => Hash::make($request->get('password')),
                'um_user_id' => $user_id,
            ]);

            $vendor = VmVendor::create([
                'id' => $user_id,
                'company_name' => $request->get('company_name'),
                'address' => $request->get('company_address'),
                'contact_email' => $request->get('company_email'),
                'contact_mobile' => $request->get('company_contact_mobile'),
                'contact_office' => $request->get('company_contact_office'),
                'um_user_id' => $user_id,
            ]);
            DB::commit();

            return redirect("/login");
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', $e->getMessage());
            session()->flash('flash_message_type', config("global.flash_error"));
            return redirect()->back()->withInput();
        }
    }



    // ====================================
    //    Обновление персональных данных
    // ====================================


    public function user_update_profile(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'firstname' => 'required',
                'company_email' => 'sometimes|required|email',
            ], [
                'company_email.required' => ':attribute поле, обязательное для заполнения.',
                'firstname.required' => ':attribute поле, обязательное для заполнения.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $userSession = $request->session()->get(config("global.session_user_obj"));

            DB::beginTransaction();
            $user_id = $userSession->id;

            $user = UmUser::find($user_id);
            $user->firstname = $request->get('firstname');
            $user->lastname = $request->get('lastname');
            $user->save();

            if ($userSession->um_user_role_id === config("global.user_role_vendor")) { // Проверка - юзера
                $vendor = VmVendor::find($user_id);
                $vendor->company_name = $request->get('company_name');
                $vendor->address = $request->get('company_address');
                $vendor->contact_email = $request->get('company_email');
                $vendor->contact_mobile = $request->get('company_contact_mobile');
                $vendor->contact_office = $request->get('company_contact_office');
                $vendor->save();
            }
            DB::commit();
            $request->session()->put(config("global.session_user_obj"), $user);

            session()->flash('message', "Профиль успешно обновлен");
            session()->flash('flash_message_type', config("global.flash_success"));
            return redirect()->back()->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', $e->getMessage());
            session()->flash('flash_message_type', config("global.flash_error"));
            return redirect()->back()->withInput();
        }
    }




    // ====================================
    //       Обновление пароля
    // ====================================




    public function user_change_password(Request $request)
    {
        try {
            $userSession = $request->session()->get(config("global.session_user_obj"));
            $user_id = $userSession->id;
            $user_login_object = UmUserLogin::find($user_id);

            if ($user_login_object === null) {
                throw new Exception("Логин не найден");
            }

            $validator = Validator::make($request->all(), [
                'old_password' => ['required', function ($attribute, $value, $fail) {
                    if (isset($user_login_object) && Hash::check($value, $user_login_object->password)) {
                        $fail('Старый пароль введене не верно');
                    }
                }],
                'password' => 'required|confirmed',
            ], [
                'old_password.required' => ':attribute поле, обязательное для заполнения.',
                'password.required' => ':attribute поле, обязательное для заполнения.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $user_login_object->password = Hash::make($request->get('password'));
            $user_login_object->save();

            $request->session()->flush();
            return redirect("/login");
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', $e->getMessage());
            session()->flash('flash_message_type', config("global.flash_error"));
            return redirect()->back()->withInput();
        }
    }



    // ====================================
    //    Админ: Управление статусом юзера
    // ====================================




    public function user_active_deactive($userId)
    {
        try {
            $msg = "";
            $user = UmUser::find($userId);
            if ($user->um_user_status_id == 1) {
                $user->um_user_status_id = 2;
                $msg = "Заблокирован";
            } else {
                $user->um_user_status_id = 1;
                $msg = "Активный";
            }
            $user->save();

            session()->flash('message', "Статус пользователя успешно обновлен");
            session()->flash('flash_message_type', config("global.flash_success"));
            return redirect("/account/admin/user-management/");
        } catch (\Exception $e) {

            session()->flash('message', $e->getMessage());
            session()->flash('flash_message_type', config("global.flash_error"));
            return redirect()->back();
        }
    }

}
