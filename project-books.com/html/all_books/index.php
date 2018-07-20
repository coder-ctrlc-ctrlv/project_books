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
        $stmt = $pdo->query('SELECT * from books');
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        while ($row = $stmt->fetch()) {
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
</div>
<?php include '../footer.php' ?>
