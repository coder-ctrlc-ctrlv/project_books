<?php
    $title = "Книги";
    $description = "Описание страницы сайта";
    $keywords = "Ключевые слова страницы сайта";
    $books_active = "active";
    include '../header.php';
?>
<div class="content" xmlns="http://www.w3.org/1999/html">
    <h1>Список книг</h1>
    <div class="sortirovka">
        <p>
            <span class="philtr">Фильтрация:</span>
            <input type="button" class="btn_philtr" id="books_rat" value="по возрастанию рейтинга" onclick="location.href='<?php if (isset ($page)) {echo "&";} else {echo "?";} ?>filtration=2'"/> /
            <input type="button" class="btn_philtr" id="books_aut" value="по убыванию рейтинга" onclick="location.href='<?php if (isset ($page)) {echo "&";} else {echo "?";} ?>filtration=3'"/> /
            <select class="search_authors" name="author">
                <option value=""></option>
                <?php
                    $stmt = $pdo->query('select author, id from authors group by author');
                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    while ($row = $stmt->fetch()) { ?>
                        <option value="<?php echo $row['id'] ?>"><?php echo $row['author']; ?></option>
                    <?php }
                ?>
            </select>
            <script>
                $(document).ready(function() {
                    $(".search_authors").select2({
                        placeholder: "Выберите автора",
                        allowClear: true
                    });
                });
            </script>

        </p>
    </div>
    <table class="col-md-12">
        <tr>
            <td class="th">Название книги</td>
            <td class="th">Дата написания</td>
            <td class="th">Объём</td>
            <td class="th">Возрастное ограничение</td>
        </tr>
        <?php
            //параметр для фильтрации
            if (isset($_GET['filtration'])){
                $filtration = $_GET['filtration'];
            }else $filtration = 1;
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
            if ($filtration == 1) {
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
            }
            if ($filtration == 2) {
                $stmt = $pdo->prepare('select b.id as id_b, avg(rating) as rat, name_book, date_of_writing, book_size, age_limit from books as b join reviews as r where r.id_book = b.id group by b.id order by rat limit :start, :kolvo');
                $stmt->execute(array(':start' => $start, ':kolvo' => $kolvo));
                foreach ($stmt as $row) {
                    $id_b=$row['id_b'];
                    echo "<tr>";
                    echo "<td class='name' onClick='location.href=\"../book?id=$id_b\"'>" . $row['name_book'] . "</td>";
                    echo "<td>" . $row['date_of_writing'] . "</td>";
                    echo "<td>" . $row['book_size'] . "</td>";
                    echo "<td>" . $row['age_limit'] . "</td>";
                    echo "</tr>";
                }
            }
            if ($filtration == 3) {
                $stmt = $pdo->prepare('select b.id as id_b, avg(rating) as rat, name_book, date_of_writing, book_size, age_limit from books as b join reviews as r where r.id_book = b.id group by b.id order by rat desc limit :start, :kolvo');
                $stmt->execute(array(':start' => $start, ':kolvo' => $kolvo));
                foreach ($stmt as $row) {
                    $id_b=$row['id_b'];
                    echo "<tr>";
                    echo "<td class='name' onClick='location.href=\"../book?id=$id_b\"'>" . $row['name_book'] . "</td>";
                    echo "<td>" . $row['date_of_writing'] . "</td>";
                    echo "<td>" . $row['book_size'] . "</td>";
                    echo "<td>" . $row['age_limit'] . "</td>";
                    echo "</tr>";
                }
            }
        ?>
    </table>
    <?php include '../pagination.php' ?>
</div>
<?php include '../footer.php' ?>
