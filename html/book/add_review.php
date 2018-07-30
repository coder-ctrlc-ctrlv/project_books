<?php
    sleep(1);
    $name = $_POST['name'];
    $message = $_POST['message'];
    $rating = $_POST['rating'];
    $id = $_POST['id'];
    echo "Ваш отзыв успешно отправлен!";
//ПОДКЛЮЧЕНИЕ К БД И ДОБАВЛЕНИЕ НОВОГО КОММЕНТАРИЯ
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
    $pdo = new PDO($dsn, $user, $pass, $opt);
    $stmt = $pdo->prepare('INSERT INTO reviews (id_book, author_review, rating, text) VALUES (:id_book, :author_review, :rating, :text)');
    $stmt->execute(array(':id_book' => $id, ':author_review' => $name, ':rating' => $rating, ':text' => $message));
?>

