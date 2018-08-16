<?php
    $title = "Библиотеки";
    $description = "Описание страницы сайта";
    $keywords = "Ключевые слова страницы сайта";
    $libraries_active = "active";
    include '../header.php';
?>
<div class="content">
    <h1>Библиотеки</h1>
    <table class="col-md-12">
        <tr>
            <td class="th">Библиотека</td>
            <td class="th">Количество представленных в ней книг</td>
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
            $stmt = $pdo->query('SELECT COUNT(*) FROM libraries');
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $row = $stmt->fetch();
            $all_record = $row['COUNT(*)'];
            //количетсво страниц
            $str_pag = ceil($all_record / $kolvo);
            $stmt = $pdo->prepare('select l.id, name_library, count(*) from libraries as l join libraries_and_books as lb on l.id=lb.id_library group by l.id limit :start, :kolvo');
            $stmt->execute(array(':start' => $start, ':kolvo' => $kolvo));
            foreach ($stmt as $row) {
                $id_l=$row['id'];
                echo "<tr>";
                echo "<tr>";
                echo "<td class='name' onClick='location.href=\"../library?id=$id_l\"'>" . $row['name_library'] . "</td>";
                echo "<td>" . $row['count(*)'] . "</td>";
                echo "</tr>";
            }
        ?>
    </table>
    <?php include '../pagination.php' ?>
</div>
<?php include '../footer.php' ?>

