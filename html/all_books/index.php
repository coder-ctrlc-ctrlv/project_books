<?php
    $title = "Книги";
    $description = "Описание страницы сайта";
    $keywords = "Ключевые слова страницы сайта";
    $books_active = "active";
    include '../header.php';
    //параметр для паджинации
    if (isset($_GET['page'])){
        $page = $_GET['page'];
    }else $page = 1;
    //параметр для фильтрации
    if (isset($_GET['filtration'])){
        $filtration = $_GET['filtration'];
    }else $filtration = 1;
    //параметр для поиска по автору
    if (isset ($_GET['id_author'])) {
        $id_a = $_GET['id_author'];
    }
?>
<div class="content" xmlns="http://www.w3.org/1999/html">
    <h1>Список книг</h1>
    <div class="sortirovka">
        <p>
            <span class="philtr">Фильтрация:</span>
            <input type="button" class="btn_philtr" id="books_rat" value="по возрастанию рейтинга" onclick="location.href='<?php if ($filtration == 4 || $filtration == 5 || $filtration == 6) {echo "?filtration=5&id_author=$id_a";} else {echo "?filtration=2";}  ?>'"/> /
            <input type="button" class="btn_philtr" id="books_aut" value="по убыванию рейтинга" onclick="location.href='<?php if ($filtration == 4 || $filtration == 5 || $filtration == 6) {echo "?filtration=6&id_author=$id_a";} else {echo "?filtration=3";}  ?>'"/> /
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
            <button type="submit" id="btn_search_aut"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
            <span id="search_info"></span>
            <script>
                $(document).ready(function() {
                    $(".search_authors").select2({
                        placeholder: "Выберите автора",
                        allowClear: true
                    });
                });
                $(function(){
                    $("#btn_search_aut").click(function() {
                        var id = $(".search_authors").val();
                        if (id != 0) {
                            location.href = '<?php if (isset ($page)) {echo "?page=" . $page . "&";} else {echo "?";} ?>filtration=4&id_author=' + id;
                            $("#search_info").text ("");
                        } else {
                            $("#search_info").text ("*Сначала выберете автора");
                        }
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
            <td class="th">Рейтинг</td>
        </tr>
        <?php
            //номер страницы
            $previous = $page - 1;
            $next = $page + 1;
            //количество выводимых записей
            $kolvo = 1;
            //номер записи, с которой начинается вывод на странице
            $start = ($page * $kolvo) - $kolvo;
            //количество всех записей
            if ($filtration != 4) {
                $stmt = $pdo->query('SELECT COUNT(*) FROM books');
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $row = $stmt->fetch();
                $all_record = $row['COUNT(*)'];
            } else {
                $stmt = $pdo->prepare('select COUNT(*) from authors_and_books as ab join books as b on b.id = ab.id_book and ab.id_author = ?');
                $stmt->execute(array($_GET['id_author']));
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $row = $stmt->fetch();
                $all_record = $row['COUNT(*)'];
            }
            //количетсво страниц
            $str_pag = ceil($all_record / $kolvo);
            //изначальный запрос
            if ($filtration == 1) {
                $stmt = $pdo->prepare('SELECT name_book, date_of_writing, book_size, age_limit, round(avg(rating),1) as rat from books as b join reviews as r on r.id_book = b.id group by b.id  limit :start, :kolvo');
                $stmt->execute(array(':start' => $start, ':kolvo' => $kolvo));
                foreach ($stmt as $row) {
                    $id_b=$row['id'];
                    echo "<tr>";
                    echo "<td class='name' onClick='location.href=\"../book?id=$id_b\"'>" . $row['name_book'] . "</td>";
                    echo "<td>" . $row['date_of_writing'] . "</td>";
                    echo "<td>" . $row['book_size'] . "</td>";
                    echo "<td>" . $row['age_limit'] . "</td>";
                    echo "<td>" . $row['rat'] . "</td>";
                    echo "</tr>";
                }
            }
            //по возрастанию рейтинга
            if ($filtration == 2) {
                $stmt = $pdo->prepare('select b.id as id_b, round(avg(rating),1) as rat, name_book, date_of_writing, book_size, age_limit from books as b join reviews as r where r.id_book = b.id group by b.id order by rat limit :start, :kolvo');
                $stmt->execute(array(':start' => $start, ':kolvo' => $kolvo));
                foreach ($stmt as $row) {
                    $id_b=$row['id_b'];
                    echo "<tr>";
                    echo "<td class='name' onClick='location.href=\"../book?id=$id_b\"'>" . $row['name_book'] . "</td>";
                    echo "<td>" . $row['date_of_writing'] . "</td>";
                    echo "<td>" . $row['book_size'] . "</td>";
                    echo "<td>" . $row['age_limit'] . "</td>";
                    echo "<td>" . $row['rat'] . "</td>";
                    echo "</tr>";
                }
            }
            //по убыванию рейтинга
            if ($filtration == 3) {
                $stmt = $pdo->prepare('select b.id as id_b, round(avg(rating),1) as rat, name_book, date_of_writing, book_size, age_limit from books as b join reviews as r where r.id_book = b.id group by b.id order by rat desc limit :start, :kolvo');
                $stmt->execute(array(':start' => $start, ':kolvo' => $kolvo));
                foreach ($stmt as $row) {
                    $id_b=$row['id_b'];
                    echo "<tr>";
                    echo "<td class='name' onClick='location.href=\"../book?id=$id_b\"'>" . $row['name_book'] . "</td>";
                    echo "<td>" . $row['date_of_writing'] . "</td>";
                    echo "<td>" . $row['book_size'] . "</td>";
                    echo "<td>" . $row['age_limit'] . "</td>";
                    echo "<td>" . $row['rat'] . "</td>";
                    echo "</tr>";
                }
            }
            //по автору
            if ($filtration == 4) {
                $stmt = $pdo->prepare('select round(avg(rating),1) as rat, b.id as id_b, name_book, date_of_writing, book_size, age_limit from authors_and_books as ab join reviews as r on r.id_book = ab.id_book join books as b on b.id = ab.id_book and ab.id_author = :id_author group by b.id limit :start, :kolvo');
                $stmt->execute(array(':start' => $start, ':id_author' => $_GET['id_author'], ':kolvo' => $kolvo));
                foreach ($stmt as $row) {
                    $id_b=$row['id_b'];
                    echo "<tr>";
                    echo "<td class='name' onClick='location.href=\"../book?id=$id_b\"'>" . $row['name_book'] . "</td>";
                    echo "<td>" . $row['date_of_writing'] . "</td>";
                    echo "<td>" . $row['book_size'] . "</td>";
                    echo "<td>" . $row['age_limit'] . "</td>";
                    echo "<td>" . $row['rat'] . "</td>";
                    echo "</tr>";
                }
            }
            //по возрастанию рейтинга книг одного автора
            if ($filtration == 5) {
                $stmt = $pdo->prepare('select round(avg(rating),1) as rat, b.id as id_b, name_book, date_of_writing, book_size, age_limit from authors_and_books as ab join reviews as r on r.id_book = ab.id_book join books as b on b.id = ab.id_book and ab.id_author = :id_author group by b.id order by rat limit :start, :kolvo');
                $stmt->execute(array(':start' => $start, ':id_author' => $_GET['id_author'], ':kolvo' => $kolvo));
                foreach ($stmt as $row) {
                    $id_b=$row['id_b'];
                    echo "<tr>";
                    echo "<td class='name' onClick='location.href=\"../book?id=$id_b\"'>" . $row['name_book'] . "</td>";
                    echo "<td>" . $row['date_of_writing'] . "</td>";
                    echo "<td>" . $row['book_size'] . "</td>";
                    echo "<td>" . $row['age_limit'] . "</td>";
                    echo "<td>" . $row['rat'] . "</td>";
                    echo "</tr>";
                }
            }
            //по убыванию рейтинга книг одного автора
            if ($filtration == 6) {
                $stmt = $pdo->prepare('select round(avg(rating),1) as rat, b.id as id_b, name_book, date_of_writing, book_size, age_limit from authors_and_books as ab join reviews as r on r.id_book = ab.id_book join books as b on b.id = ab.id_book and ab.id_author = :id_author group by b.id order by rat desc limit :start, :kolvo');
                $stmt->execute(array(':start' => $start, ':id_author' => $_GET['id_author'], ':kolvo' => $kolvo));
                foreach ($stmt as $row) {
                    $id_b=$row['id_b'];
                    echo "<tr>";
                    echo "<td class='name' onClick='location.href=\"../book?id=$id_b\"'>" . $row['name_book'] . "</td>";
                    echo "<td>" . $row['date_of_writing'] . "</td>";
                    echo "<td>" . $row['book_size'] . "</td>";
                    echo "<td>" . $row['age_limit'] . "</td>";
                    echo "<td>" . $row['rat'] . "</td>";
                    echo "</tr>";
                }
            }
        ?>
    </table>
    <?php include '../pagination.php' ?>
</div>
<?php include '../footer.php' ?>
