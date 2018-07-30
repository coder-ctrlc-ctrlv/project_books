<?php
    $title = "Автор";
    $description = "Описание страницы сайта";
    $keywords = "Ключевые слова страницы сайта";
    include '../header.php';
?>
<div class="content">
    <?php
        $one = 0;
        $res = $pdo->prepare('select name_book, author, b.id as book_id from authors_and_books as ab
join
books as b on b.id=ab.id_book 
join 
authors as a on a.id=ab.id_author and a.id=?');
        $res->execute(array($_GET['id']));
        foreach ($res as $row) {
            $one++;
            if ($one==1) {
                echo "<h1>" . $row['author'] . "</h1>";
                echo "<h3>" . "Список книг:" . "</h3>";
                echo "<table class=\"col-md-6\">";
            }
            echo "<tr>";
            $id_b = $row['book_id'];
            echo "<td class='td_la' onClick='location.href=\"../book?id=$id_b\"'>" . $row['name_book'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    ?>
</div>
<?php include '../footer.php' ?>