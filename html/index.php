<?php
    $title = "Главная";
    $description = "Описание страницы сайта";
    $keywords = "Ключевые слова страницы сайта";
    $main_active = "active";
    include 'header.php';
?>
<div class="content">
    <div class="left_content">
        <h1>5 лучших книг</h1>
        <ol class="square">
            <?php
                $stmt = $pdo->query('select b.id as id_b, avg(rating) as rat, name_book from books as b join reviews as r where r.id_book = b.id group by b.id order by rat desc limit 5');
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                while ($row = $stmt->fetch()) {
                    $id_b = $row['id_b'];
                    echo "<li><a href='book?id=$id_b'>" . $row['name_book'] . " </a>(<b>Средняя оценка:</b> " . $row['rat'] . ")</li>";
                }
            ?>
        </ol>
    </div>
    <div class="right_content">
        <h1>5 лучших авторов</h1>
        <ol class="square">
            <?php
                $stmt = $pdo->query('select a.id as id_a, author, count(*) as kolvo from authors as a join authors_and_books as ab on a.id=ab.id_author group by a.id order by kolvo desc limit 5');
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                while ($row = $stmt->fetch()) {
                    $id_a = $row['id_a'];
                    echo "<li><a href='author?id=$id_a'>" . $row['author'] . " </a>(<b>Количество написанных книг:</b> " . $row['kolvo'] . ")</li>";
                }
            ?>
        </ol>
    </div>
    <div class="center_content">
        <h1>Последние отзывы</h1>
        <div class="last_reviews">
            <?php
                $stmt = $pdo->query('SELECT id_book, author_review, rating, text, name_book from reviews as r join books as b where b.id = r.id_book  group by r.id desc limit 5');
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                while ($row = $stmt->fetch()) {
                    $id_b = $row['id_book'];
                    echo "<div class='main_review'>";
                    echo "<b>Название книги: </b><a href='book?id=$id_b']'> " . $row['name_book'] . "</a><br />";
                    echo "<b>Имя: </b>" . $row['author_review'] . "<br />";
                    echo "<b>Оценка: </b>" . $row['rating'] . "<br  /><div class='line'></div>";
                    echo "<b>Отзыв: </b>" . $row['text'] . "<br />";
                    echo "</div>";
                }
            ?>
        </div>
    </div>
</div>
<?php include 'footer.php' ?>
