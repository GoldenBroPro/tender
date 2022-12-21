<!DOCTYPE html>
<html>

<head>


    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Регистрация</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-6 col-md-auto">
                <div class=" animated fadeInDown m-t">
                    <div class="text-center">
                        <img src="images/logo-only.png" style="width: 20%;height: 20%">
                        <br><br>
                    </div>
                    <div class="ibox">
                        <div class="ibox-content">
                            <form class="m-t" action="user-actions/register" method="POST">
                                {{ csrf_field() }}
                                @include('include.flash')
                                @include('include.errors')
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <b>Персональные данные</b>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form-group  row align-left"><label
                                                class="col-sm-4 col-form-label">Имя</label>
                                            <div class="col-sm-8"><input type="text" name="firstname"
                                                    value="{{ old('firstname') }}"
                                                    class="form-control @error('title') is-invalid @enderror"></div>
                                        </div>
                                        <div class="form-group  row"><label
                                                class="col-sm-4 col-form-label">Фамилия</label>
                                            <div class="col-sm-8"><input type="text" name="lastname"
                                                    value="{{ old('lastname') }}" class="form-control"></div>
                                        </div>
                                    </div>

                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <b>Информация о безопасности</b>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form-group  row align-left"><label
                                                class="col-sm-4 col-form-label">Почта</label>
                                            <div class="col-sm-8"><input type="text" name="username"
                                                    value="{{ old('username') }}" class="form-control"></div>
                                        </div>
                                        <div class="form-group  row"><label
                                                class="col-sm-4 col-form-label">Пароль</label>
                                            <div class="col-sm-8"><input type="password" name="password"
                                                    class="form-control"></div>
                                        </div>
                                        <div class="form-group  row"><label class="col-sm-4 col-form-label">Повторите
                                                пароль</label>
                                            <div class="col-sm-8"><input type="password" name="password_confirmation"
                                                    class="form-control"></div>
                                        </div>
                                    </div>

                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <b>Информация о компании</b>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form-group  row"><label class="col-sm-4 col-form-label">Название
                                                компании</label>
                                            <div class="col-sm-8 "><input type="text" name="company_name"
                                                    value="{{ old('company_name') }}" class="form-control "></div>
                                        </div>
                                        <div class="form-group  row"><label
                                                class="col-sm-4 col-form-label">Адрес</label>
                                            <div class="col-sm-8"><input type="text" name="company_address"
                                                    value="{{ old('company_address') }}" class="form-control"></div>
                                        </div>
                                        <div class="form-group  row "><label class="col-sm-4 col-form-label">Эл.
                                                адрес</label>
                                            <div class="col-sm-8"><input type="email" name="company_email"
                                                    value="{{ old('company_email') }}" class="form-control"></div>
                                        </div>
                                        <div class="form-group  row"><label
                                                class="col-sm-4 col-form-label">Телефон</label>
                                            <div class="col-sm-8"><input type="text" name="company_contact_mobile"
                                                    value="{{ old('company_contact_mobile') }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group  row"><label class="col-sm-4 col-form-label">Контакт
                                                (Офиса) </label>
                                            <div class="col-sm-8"><input type="text" name="company_contact_office"
                                                    value="{{ old('company_contact_office') }}" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                </div>


                                <button type="submit"
                                    class="btn btn-secondary btn-lg block full-width m-b">Зарегистрироваться</button>

                                <p class="text-muted text-center"><small><b>У вас уже есть аккаунт?</b></small></p>
                                <a class="btn btn-danger btn-outline block full-width m-b " href="/login">Войти</a>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>

</body>

</html>
