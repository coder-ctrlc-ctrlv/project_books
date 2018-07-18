<?php
    $title = "Авторы";
    $description = "Описание страницы сайта";
    $keywords = "Ключевые слова страницы сайта";
    $authors_active = "active";
    include '../header.php';
?>
<div class="content">
    <h1>Список авторов</h1>
    <?php
    $stmt = $pdo->query('SELECT * from authors');
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    while($row = $stmt->fetch())
    {   
        echo "<div class='block'>";
        echo "<p class='center_author'>" . $row['author'] . "</p>";
        if ($row['author']=="Стивен Кинг"){
            echo "<img class='author' src=''>";
        }
        echo "</div>";
    }
    ?>
</div>
<?php include '../footer.php' ?>

 
 
