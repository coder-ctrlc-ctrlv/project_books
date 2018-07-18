<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title ?></title>
    <meta name="keywords" content="<?php echo $keywords ?>">
    <meta name="Description" content=” <?php echo $description ?> “>
<!-- style -->
    <link rel="stylesheet" href="../style.css"
<!-- Bootstrap -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="../css/dopstyle.css" rel="stylesheet" media="screen">
<body>
<!-- Оболочка -->
    <div class="wrapper">
<!-- Весь контент -->
        <div class="content">
<!-- MENU -->
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="container-fluid">
<!--Название сайта и кнопка раскрытия меню для мобильных-->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="../index.php">PROJECT-BOOKS.COM</a>
                    </div>
<!--Само меню-->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li class="<?=$main_active;?>"><a href="../index.php">Главная</a></li>
                            <li class="<?=$books_active;?>"><a href="../all_books">Книги</a></li>
                            <li class="<?=$authors_active;?>"><a href="../all_authors">Авторы</a></li>
                            <li class="<?=$libraries_active;?>"><a href="../all_libraries">Библиотеки</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
            <img class="header_photo" src="../img/header3.jpg" alt="">
            <img class="uzor" src="../img/uzor1.jpg" alt="">

