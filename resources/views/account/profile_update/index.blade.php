@extends('layout/main')

@section('content')
    @include('include.flash')
    @include('include.errors')

    <div class="row m-t">
        <div class="col-md-6">
            <form action="user-actions/profile/update" method="POST">
                {{ csrf_field() }}
                <div class="panel panel-default">
                    <div class="panel-heading ">
                        <h4><strong>Персональные данные</strong></h4>
                    </div>
                    <div class="panel-body">
                        <div class="form-group row "><label class="col-4 col-form-label"><strong>Имя <span
                                        class="text-danger"></span>:</strong></label>
                            <div class="col-8">
                                <input type="text" name="firstname" value="{{ $userData->firstname }}"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="form-group row "><label class="col-4 col-form-label"><strong>Фамилия :</strong></label>
                            <div class="col-8">
                                <input type="text" name="lastname" value="{{ $userData->lastname }}"
                                    class="form-control">
                            </div>
                        </div>

                        @if ($userData->um_user_role_id == 1)
                            <div class="form-group row "><label class="col-4 col-form-label"><strong>Название
                                        компании:</strong></label>
                                <div class="col-8">
                                    <input type="text" name="company_name" value="{{ $userData->vendor->company_name }}"
                                        class="form-control ">
                                </div>
                            </div>
                            <div class="form-group row "><label class="col-4 col-form-label"><strong>Адрес:</strong></label>
                                <div class="col-8">
                                    <input type="text" name="company_address" value="{{ $userData->vendor->address }}"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="form-group row "><label class="col-4 col-form-label"><strong>Email <span
                                            class="text-danger"></span>:</strong></label>
                                <div class="col-8">
                                    <input type="email" name="company_email"
                                        value="{{ $userData->vendor->contact_email }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row "><label class="col-4 col-form-label"><strong>Телефон <span
                                            class="text-danger"></span>:</strong></label>
                                <div class="col-8">
                                    <input type="text" name="company_contact_mobile"
                                        value="{{ $userData->vendor->contact_mobile }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row "><label class="col-4 col-form-label"><strong>Контакт
                                        (Офиса):</strong></label>
                                <div class="col-8">
                                    <input type="text" name="company_contact_office"
                                        value="{{ $userData->vendor->contact_office }}" class="form-control">
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
                <div class="col-md-12">
                    <button class="btn btn-sm btn-secondary btn-lg float-right" type="submit">Обновить</button>

                </div>
            </form>
        </div>

        <div class="col-md-6">
            <form action="user-actions/profile/change-password" method="POST">
                {{ csrf_field() }}
                <div class="panel panel-default">
                    <div class="panel-heading ">
                        <h4><strong>Информация о безопасности</strong></h4>
                    </div>
                    <div class="panel-body">
                        <div class="form-group row "><label class="col-4 col-form-label"><strong>Старый пароль <span
                                        class="text-danger"></span>:</strong></label>
                            <div class="col-8">
                                <input type="password" name="old_password" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row "><label class="col-4 col-form-label"><strong>Новый пароль <span
                                        class="text-danger"></span>:</strong></label>
                            <div class="col-8"><input type="password" name="password" class="form-control"></div>
                        </div>
                        <div class="form-group row "><label class="col-4 col-form-label"><strong>Подвердите пароль <span
                                        class="text-danger"></span>:</strong></label>
                            <div class="col-8"><input type="password" name="password_confirmation" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <button class="btn btn-sm btn-secondary btn-lg float-right" type="submit">Обновить</button>

                </div>
            </form>
        </div>
    </div>
@endsection
