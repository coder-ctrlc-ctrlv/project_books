<?php
    $title = "Книга";
    $description = "Описание страницы сайта";
    $keywords = "Ключевые слова страницы сайта";
    include '../header.php';
?>
<div class="content">
    <?php
    $res = $pdo->prepare('select * from books where id = ?');
    $res->execute(array($_GET['id']));
    foreach ($res as $row) {
        echo "<h1>" . $row['name_book'] . "</h1>";
        $k=0;
        $arr_authors=[];
        $arr_id_authors=[];
        $res_1 = $pdo->prepare('select * from authors as a join authors_and_books as ab, books as b where ab.id_author = a.id and b.id = ab.id_book and b.id=?');
        $res_1->execute(array($_GET['id']));
        foreach ($res_1 as $row_1) {
            array_push ($arr_authors, $row_1['author']);
            array_push ($arr_id_authors, $row_1['id_author']);
        }
        if (count($arr_authors)==1){
            echo "<b>Автор:</b><a href='../author?id=$arr_id_authors[0]'> " . $arr_authors[0] . "</a><br />";
        } else {
            echo "<b>Авторы:</b> ";
            foreach ($arr_authors as $value){
                $k++;
                if ($k==1){
                    echo "<a href='../author?id=$arr_id_authors[0]'>" . $value . "</a>";
                } else {
                    echo ", " . "<a href='../author?id=$arr_id_authors[$i]'>" . $value . "</a>";
                }
            }
            echo "<br />";
        }
        echo "<b>Дата написания:</b> " . $row['date_of_writing'] . "<br />";
        echo "<b>Объем:</b> " . $row['book_size'] . "<br />";
        echo "<b>Возрастное ограничение:</b> " . $row['age_limit'] . "<br />";
    }
    ?>
</div>
<?php include '../footer.php' ?>
 
 
