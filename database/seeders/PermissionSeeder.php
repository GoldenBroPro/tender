<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\PmPermissions;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ar_permissions=[
            //Админ панель
            ["id"=>1000,"permission"=>"Create/Edit Tender Categories","tab_name"=>"Категории",'url_path'=>'admin/categorries','is_tab'=>1,'order_no'=>1],
            ["id"=>1001,"permission"=>"Create Tender","tab_name"=>"Создать тендер",'url_path'=>'admin/new','is_tab'=>1,'order_no'=>2],
            ["id"=>1002,"permission"=>"List Unpublished/Draft Tenders","tab_name"=>"Тендеры",'url_path'=>'admin/drafts','is_tab'=>1,'order_no'=>3],
            ["id"=>1003,"permission"=>"View Tender Bids","tab_name"=>"Заявки",'url_path'=>'admin/bids','is_tab'=>1,'order_no'=>4],
            ["id"=>1004,"permission"=>"Active/Block users","tab_name"=>"Пользователи",'url_path'=>'admin/user-management','is_tab'=>1,'order_no'=>5],

            //Юзер панель
            ["id"=>2000,"permission"=>"View all bids of user","tab_name"=>"Все заявки",'url_path'=>'user/bids','is_tab'=>1,'order_no'=>2000],
            ["id"=>2100,"permission"=>"Create Offer","tab_name"=>"Create Offer",'url_path'=>'','is_tab'=>0,'order_no'=>2100],
            ["id"=>2001,"permission"=>"View all approved of user","tab_name"=>"Одобренные заявки",'url_path'=>'user/approved-bids','is_tab'=>1,'order_no'=>2001],
        ];

        foreach ($ar_permissions as $permission) {
            PmPermissions::updateOrCreate([
                'id' => $permission['id']
            ],$permission);
        }
    }
}
