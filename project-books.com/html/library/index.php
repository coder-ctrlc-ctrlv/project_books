<?php
    $title = "Библиотека";
    $description = "Описание страницы сайта";
    $keywords = "Ключевые слова страницы сайта";
    include '../header.php';
?>
<div class="content">
    <?php
    $res = $pdo->prepare('select * from libraries where id = ?');
    $res->execute(array($_GET['id']));
    foreach ($res as $row) {
        echo "<h1>" . $row['name_library'] . "</h1>";
    }

    ?>
</div>
<?php include '../footer.php' ?>
 
 
