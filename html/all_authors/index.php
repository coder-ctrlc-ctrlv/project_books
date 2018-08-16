<?php
    $title = "Авторы";
    $description = "Описание страницы сайта";
    $keywords = "Ключевые слова страницы сайта";
    $authors_active = "active";
    include '../header.php';
?>
<div class="content">
    <h1>Список авторов</h1>
    <div class="sortirovka">
        <p>
            <span class="philtr">Фильтрация:</span>
            <input type="button" class="btn_philtr" id="aut_alf" value="по алфавиту" onclick="location.href='<?php if (isset ($page)) {echo "&";} else {echo "?";} ?>filtration=2'" />
        </p>
    </div>
    <table class="col-md-12">
        <tr>
            <td class="th">Автор</td>
            <td class="th">Количество книг</td>
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
            $stmt = $pdo->query('SELECT COUNT(*) FROM authors');
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $row = $stmt->fetch();
            $all_record = $row['COUNT(*)'];
            //количетсво страниц
            $str_pag = ceil($all_record / $kolvo);
            if ($filtration == 1) {
                $stmt = $pdo->prepare('select a.id, author, count(*) from authors as a join authors_and_books as ab on a.id=ab.id_author group by a.id limit :start, :kolvo');
                $stmt->execute(array(':start' => $start, ':kolvo' => $kolvo));
                foreach ($stmt as $row) {
                    $id_a = $row['id'];
                    echo "<tr>";
                    echo "<td class='name' onClick='location.href=\"../author?id=$id_a\"'>" . $row['author'] . "</td>";
                    echo "<td>" . $row['count(*)'] . "</td>";
                    echo "</tr>";
                }
            }
            if ($filtration == 2) {
                $stmt = $pdo->prepare('select a.id, author, count(*) from authors as a join authors_and_books as ab on a.id=ab.id_author group by author limit :start, :kolvo');
                $stmt->execute(array(':start' => $start, ':kolvo' => $kolvo));
                foreach ($stmt as $row) {
                    $id_a = $row['id'];
                    echo "<tr>";
                    echo "<td class='name' onClick='location.href=\"../author?id=$id_a\"'>" . $row['author'] . "</td>";
                    echo "<td>" . $row['count(*)'] . "</td>";
                    echo "</tr>";
                }
            }
        ?>
    </table>
    <?php include '../pagination.php' ?>
</div>
<?php include '../footer.php' ?>



