<?php
    $title = "Автор";
    $description = "Описание страницы сайта";
    $keywords = "Ключевые слова страницы сайта";
    include '../header.php';
    //параметр для фильтрации
    if (isset($_GET['filtration'])){
        $filtration = $_GET['filtration'];
    }else $filtration = 1;
?>
<div class="content">
    <?php
        $res = $pdo->prepare('select author from authors as a where a.id = ?');
        $res->execute(array($_GET['id']));
        $res->setFetchMode(PDO::FETCH_ASSOC);
        $row = $res->fetch();
        echo "<h1>" . $row['author'] . "</h1>";
    ?>
    <h3>Список книг:</h3>
    <div class='tabs'>
        <input id='tab1' type='radio' name='tabs' onclick="location.href='?id=<?php echo $_GET['id']; ?>//&filtration=1'" <?php if ($filtration == 1 || isset ($filtration)) {echo "checked";} ?>>
        <label for='tab1' title='Вкладка 1'><span class='glyphicon glyphicon-user' aria-hidden='true'></span> Полное авторство</label>
        <input id='tab2' type='radio' name='tabs' onclick="location.href='?id=<?php echo $_GET['id']; ?>//&filtration=2'" <?php if ($filtration == 2) {echo "checked";} ?>>
        <label for='tab2' title='Вкладка 2'><span class='glyphicon glyphicon-user' aria-hidden='true'></span><span class='glyphicon glyphicon-user' aria-hidden='true'></span> Соавторство</label>
    <?php
        if ($filtration == 1) {
            $one_1 = 0;
            $res = $pdo->prepare('select name_book, id_book, id_author, count(*) as count_authors from books as b join
authors_and_books as ab on ab.id_book = b.id where b.id  in (select id_book from authors_and_books where id_author = ?) group by b.id having count_authors = 1 ;');
            $res->execute(array($_GET['id']));
            foreach ($res as $row) {
                $one_1++;
                if ($one_1 == 1) {
                    echo "<section id='content-tab1'><p>";
                    echo "<table class='table_aut_b'>";
                }
                echo "<tr>";
                $id_b = $row['id_book'];
                echo "<td class='td_la' onClick='location.href=\"../book?id=$id_b\"'>" . $row['name_book'] . "</td>";
                echo "</tr>";
            }
            if ($one_1 != 0) {
                echo "</table></p></section>";
            } else {
                echo "<section id='content-tab1'><p>Книги в полном авторстве отсутствуют</p></section>";
            }
        }
        if ($filtration == 2) {
            $one_2 = 0;
            $res = $pdo->prepare('select name_book, id_book, id_author, count(*) as count_authors from books as b join
authors_and_books as ab on ab.id_book = b.id where b.id  in (select id_book from authors_and_books where id_author = ?) group by b.id having count_authors > 1 ;');
            $res->execute(array($_GET['id']));
            foreach ($res as $row) {
                $one_2++;
                if ($one_2 == 1) {
                    echo "<section id='content-tab2'><p>";
                    echo "<table class='table_aut_b'>";
                }
                echo "<tr>";
                $id_b = $row['id_book'];
                echo "<td class='td_la' onClick='location.href=\"../book?id=$id_b\"'>" . $row['name_book'] . "</td>";
                echo "</tr>";
            }
            if ($one_2 != 0) {
                echo "</table></p></section>";
            } else {
                echo "<section id='content-tab2'><p>Книги в соавторстве отсутствуют</p></section>";
            }
        }
    ?>
    </div>
</div>
<?php include '../footer.php' ?>