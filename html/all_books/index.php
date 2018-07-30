<?php
    $title = "Книги";
    $description = "Описание страницы сайта";
    $keywords = "Ключевые слова страницы сайта";
    $books_active = "active";
    include '../header.php';
?>
<div class="content">
    <h1>Список книг</h1>
    <table class="col-md-12">
        <tr>
            <td class="th">Название книги</td>
            <td class="th">Дата написания</td>
            <td class="th">Объём</td>
            <td class="th">Возрастное ограничение</td>
        </tr>
        <?php
            //номер страницы
            if (isset($_GET['page'])){
                $page = $_GET['page'];
            }else $page = 1;
            $previous = $page - 1;
            $next = $page + 1;
            //количество выводимых записей
            $kolvo = 10;
            //номер записи, с которой начинается вывод на странице
            $start = ($page * $kolvo) - $kolvo;
            //количество всех записей
            $stmt = $pdo->query('SELECT COUNT(*) FROM books');
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $row = $stmt->fetch();
            $all_record = $row['COUNT(*)'];
            //количетсво страниц
            $str_pag = ceil($all_record / $kolvo);
            $stmt = $pdo->prepare('SELECT * from books limit :start, :kolvo');
            $stmt->execute(array(':start' => $start, ':kolvo' => $kolvo));
            foreach ($stmt as $row) {
                $id_b=$row['id'];
                echo "<tr>";
                echo "<td class='name' onClick='location.href=\"../book?id=$id_b\"'>" . $row['name_book'] . "</td>";
                echo "<td>" . $row['date_of_writing'] . "</td>";
                echo "<td>" . $row['book_size'] . "</td>";
                echo "<td>" . $row['age_limit'] . "</td>";
                echo "</tr>";
            }
        ?>
    </table>
    <?php include '../pagination.php' ?>
</div>
<?php include '../footer.php' ?>
