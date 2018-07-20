<?php
    $title = "Авторы";
    $description = "Описание страницы сайта";
    $keywords = "Ключевые слова страницы сайта";
    $authors_active = "active";
    include '../header.php';
?>
<div class="content">
    <h1>Список авторов</h1>
    <table class="col-md-12">
        <tr>
            <td class="th">Автор</td>
            <td class="th">Количество книг</td>
        </tr>
        <?php
        $kolvo=0;
        $stmt = $pdo->query('SELECT * from authors');
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        while ($row = $stmt->fetch()) {
            $id_a=$row['id'];
            echo "<tr>";
            echo "<tr>";
            echo "<td class='name' onClick='location.href=\"../author?id=$id_a\"'>" . $row['author'] . "</td>";
            $res = $pdo->prepare('select * from authors_and_books where id_author=?');
            $res->execute(array($row['id']));
            foreach ($res as $rows) {
                $kolvo++;
            }
            echo "<td>" . $kolvo . "</td>";
            echo "</tr>";
            $kolvo=0;
        }
        ?>
    </table>
</div>
<?php include '../footer.php' ?>



