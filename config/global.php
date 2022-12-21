<?php

return [
    //Статус пользователя
    'user_status_pending'=>0,
    'user_status_active'=>1,
    'user_status_blocked'=>2,

    //Пользовательские роли
    'user_role_admin'=>0,
    'user_role_vendor'=>1,

    //оповещения
    'flash_success'=>'alert-success',
    'flash_error'=>'alert-danger',

     //Тендерный статус
     'tender_removed'=>0,
     'tender_publish'=>1,
     'tender_draft'=>2,
     'tender_closed'=>3,

     //Атрибуты сеанса
     'session_user_obj'=>"logged_user_object",
     'session_permissions'=>"permissions",
     'session_permissions_tabs'=>"permissions_tabs",

     //Статус
     'offer_status_pending'=>0,
     'offer_status_approved'=>1,
     'offer_status_rejected'=>2,

     'offer_status_action_approve'=>"Одобрить",
     'offer_status_action_reject'=>"Отклонить",
     'offer_status_action_revert'=>"Отменить",
];

?>
