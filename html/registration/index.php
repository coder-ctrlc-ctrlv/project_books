<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="style_registration.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="../bootstrap/css/dopstyle.css" rel="stylesheet" media="screen">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
</head>
<body>
    <div id="fullscreen_bg" class="fullscreen_bg"/>
    <div id="regContainer" class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-login">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-6">
                                <a href="#" class="active" id="login-form-link">Авторизация</a>
                            </div>
                            <div class="col-xs-6">
                                <a href="#" id="register-form-link">Регистрация</a>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <form id="login-form" action="" method="post" role="form" style="display: block;">
                                    <div class="form-group">
                                        <label for="username">Логин</label>
                                        <input type="text" name="username" id="username1" tabindex="1" class="form-control" placeholder="Введите логин" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Пароль</label>
                                        <input type="password" name="password" id="password1" tabindex="2" class="form-control" placeholder="Введите пароль" required>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6 col-sm-offset-3">
                                                <input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Авторизироваться">
                                                <p id="aut_err"></p>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <form id="register-form" action="" method="post" role="form" style="display: none;">
                                    <div class="form-group">
                                        <label for="username">Логин</label>
                                        <input type="text" name="username" id="username2" tabindex="1" class="form-control" placeholder="Введите логин" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">E-mail</label>
                                        <input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="Введите Email" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Пароль</label>
                                        <input type="password" name="password" id="password2" tabindex="2" class="form-control" placeholder="Введите пароль" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="confirm-password">Повторите пароль</label>
                                        <input type="password" name="confirm-password" id="confirm-password" tabindex="2" class="form-control" placeholder="Введите свой пароль еще раз" required>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6 col-sm-offset-3">
                                                <input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Зарегестрироваться">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--Обработка авторизации-->
    <?php
        if ( !empty($_POST['password']) and !empty($_POST['username']) ) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $username_1 = $username;
            $host = '127.0.0.1';
            $db = 'base_for_books';
            $user = 'user';
            $pass = 'user';
            $charset = 'utf8';
            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
            $opt = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $pdo = new PDO($dsn, $user, $pass, $opt);
            $stmt = $pdo->prepare('select * from users where username = :username or email = :username_1');
            $stmt->execute(array(':username' => $username, ':username_1' => $username_1));
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $row = $stmt->fetch();
            if (!empty($row) and $password == $row['password']){
                session_start();
                $_SESSION['auth'] = true;
                $_SESSION['username'] = $username;?>
                <script>document.location.href='../index.php'</script><?php
            } else {?>
                <script> $("#aut_err").text ("Неверный логин или пароль!")</script><?php
            }
        }
    ?>
<!--Обработка регистрации-->
    <?php
        
    ?>
    <script>
        $(function() {
            $('#login-form-link').click(function(e) {
                $("#login-form").delay(100).fadeIn(100);
                $("#register-form").fadeOut(100);
                $('#register-form-link').removeClass('active');
                $(this).addClass('active');
                e.preventDefault();
            });
            $('#register-form-link').click(function(e) {
                $("#register-form").delay(100).fadeIn(100);
                $("#login-form").fadeOut(100);
                $('#login-form-link').removeClass('active');
                $(this).addClass('active');
                e.preventDefault();
            });
        });
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="../bootstrap/js/popper.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
</body>
</html>