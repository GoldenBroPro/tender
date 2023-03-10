<!DOCTYPE html>
<html>

<head>


    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Вход</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">
    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>


                <img src="images/logo-only.png" style="width: 30%;height: 30%"> <br><br>
            </div>
            <div class="ibox">
                <div class="ibox-content">

                    <form class="m-t" action="user-actions/login" method="POST">
                        {{ csrf_field() }}
                        @include('include.flash')
                        @include('include.errors')

                        <div class="form-group custmm">
                            <input type="text" class="form-control custmm" autofocus placeholder="Почта"
                                name="username">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Пароль" name="password">
                        </div>
                        <button type="submit" class="btn btn-secondary btn-lg block full-width m-b">Войти</button>

                        <p class="text-muted text-center"><small><b>Нет аккаунта?</b></small></p>
                        <a class="btn btn-sm btn-danger btn-outline btn-block" href="/register">Зарегистрироваться</a>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>

</body>

</html>
