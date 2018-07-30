<?php
    $title = "Библиотека";
    $description = "Описание страницы сайта";
    $keywords = "Ключевые слова страницы сайта";
    include '../header.php';
?>
<div class="content">
    <?php
        $one = 0;
        $res = $pdo->prepare('select name_book, name_library, b.id as book_id from libraries_and_books as lb
join
books as b on b.id=lb.id_book 
join 
libraries as l on l.id=lb.id_library and l.id=?');
        $res->execute(array($_GET['id']));
        foreach ($res as $row) {
            $one++;
            if ($one==1) {
                echo "<h1>" . $row['name_library'] . "</h1>";
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
 
 
