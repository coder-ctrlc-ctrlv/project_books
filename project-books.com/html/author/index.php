<?php
    $title = "Автор";
    $description = "Описание страницы сайта";
    $keywords = "Ключевые слова страницы сайта";
    include '../header.php';
?>
<div class="content">
    <?php
    $res = $pdo->prepare('select * from authors where id = ?');
    $res->execute(array($_GET['id']));
    foreach ($res as $row) {
        echo "<h1>" . $row['author'] . "</h1>";
    }

    ?>
</div>
<?php include '../footer.php' ?>