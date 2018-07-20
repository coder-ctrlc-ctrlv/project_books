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
        $stmt = $pdo->query('SELECT * from libraries');
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        while ($row = $stmt->fetch()) {
            $id_l=$row['id'];
            echo "<tr>";
            echo "<td class='name' onClick='location.href=\"../library?id=$id_l\"'>" . $row['name_library'] . "</td>";
            $res = $pdo->prepare('select * from libraries_and_books where id_library=?');
            $res->execute(array($row['id']));
            foreach ($res as $rows)
            {
                $kolvo++;
            }
            echo "<td>" . $kolvo . "</td>";
            $kolvo=0;
            echo "</tr>";
        }
        ?>
    </table>
</div>
<?php include '../footer.php' ?>
 
