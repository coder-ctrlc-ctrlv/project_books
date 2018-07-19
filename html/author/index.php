<?php
    $title = "Автор";
    $description = "Описание страницы сайта";
    $keywords = "Ключевые слова страницы сайта";
    include '../header.php';
?>
<div class="content">
    <?php
    $stmt = $pdo->query('SELECT * from authors');
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    while ($row = $stmt->fetch()) {
        
    }
    ?>
    <h1>Отдельный автор</h1>
    
</div>
<?php include '../footer.php' ?>
 
 
