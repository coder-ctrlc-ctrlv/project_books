<?php
    $title = "Книга";
    $description = "Описание страницы сайта";
    $keywords = "Ключевые слова страницы сайта";
    include '../header.php';
?>
<div class="content">
    <?php
        $one = 0;
        $k = 0;
        $arr_genres = [];
        $arr_authors = [];
//ЗАПРОС И ЗАПОЛНЕНИЕ МАССИВОВ
        $res = $pdo->prepare('select name_book, date_of_writing, book_size, age_limit,author, genre,a.id as auth_id, g.id as genre_id  from authors_and_books as ab
join
genres_and_books as gb on gb.id_book=ab.id_book 
join
books as b on b.id=gb.id_book and b.id=?
join 
authors as a on a.id=ab.id_author 
join
genres as g on g.id=gb.id_genre');
        $res->execute(array($_GET['id']));
        foreach ($res as $row) {
            $one++;
            if ($one==1) {
                echo "<h1>" . $row['name_book'] . "</h1>";
                $date=$row['date_of_writing'];
                $size=$row['book_size'];
                $age=$row['age_limit'];
            }
            $arr_genres[$row['genre_id']] = $row['genre'];
            $arr_authors[$row['auth_id']] = $row['author'];
        }
        echo "<div class='book_info'>";
//ВЫВОД АВТОРОВ
        echo "<b></b>";
        if (count($arr_authors) == 1) {
            foreach ($arr_authors as $value) {
                $id_a = array_search($value, $arr_authors);
                echo "<b>Автор:</b><a href='../author?id=$id_a'> " . $value . "</a><br />";
            }
        } else {
            echo "<b>Авторы:</b> ";
            foreach ($arr_authors as $value) {
                $id_a = array_search($value, $arr_authors);
                $k++;
                if ($k==1) {
                    echo  "<a href='../author?id=$id_a'>" . $value . '</a>';
                } else {
                    echo ",<a href='../author?id=$id_a'> " . $value . '</a>';
                }
            }
            echo "<br />";
            $k=0;
        }
//ВЫВОД ЖАНРОВ
        if (count($arr_genres) == 1) {
            foreach ($arr_genres as $value) {
                echo "<b>Жанр:</b> " . $value . "<br />";
            }
        } else {
            echo "<b>Жанры:</b> ";
            foreach ($arr_genres as $value) {
                $k++;
                if ($k==1) {
                    echo  $value;
                } else {
                    echo ", " . $value;
                }
            }
            echo "<br />";
            $k=0;
        }
        echo "<b>Дата написания:</b> " . $date . "<br />";
        echo "<b>Объем:</b> " . $size . "<br />";
        echo "<b>Возрастное ограничение:</b> " . $age . "<br /></div>";
    ?>
    
<!--ФОРМА ДЛЯ ОТЗЫВОВ-->
    <h2>Оставьте отзыв о книге</h2>
    <form action="add_review.php" method="post" role="form" id="reviewsForm">
        <div class="row">
            <div class="form-group col-sm-6">
                <label for="name" class="h4">Имя:</label>
                <input type="text" class="form-control" id="name" placeholder="Введите ваше имя">
                <p id="name_error"></p>
            </div>
            <div class="form-group col-sm-6">
                <label for="rayting" class="h4">Оценка:</label>
                <input type="number" min="1" max="10" class="form-control" id="rating" placeholder="От 1 до 10">
                <p id="rating_error"></p>
            </div>
        </div>
        <div class="form-group">
            <label for="message" class="h4 ">Отзыв:</label>
            <textarea id="message" class="form-control" rows="5" placeholder="Введите ваше сообщение"></textarea>
            <p id="message_error"></p>
        </div>
        <input type="button" id="send" class="btn_rev" value="Отправить" />
        <div class="dop_div">&nbsp</div>
        <p id="end_info"></p>
    </form>
<!--СКРИПТ AJAX-->
    <script type="text/javascript">
        function funcBefore () {
            $("#end_info").text ("Отправление...");
            $("#name_error").text ("");
            $("#message_error").text ("");
            $("#rating_error").text (" ");
        }
        function funcSuccess (data) {
            $("#end_info").text (data);
            document.getElementById('name').value = '';
            document.getElementById('rating').value = '';
            document.getElementById('message').value = '';
        }
        $(document).ready (function () {
            $("#send").bind("click", function () {
                var name = $("input#name").val();
                var message = $("textarea#message").val();
                var rating = $("input#rating").val();
                var arr_errors = [];
                //валидация
                if (name == '') {
                    arr_errors[0] = '*Поле ИМЯ должно быть заполено';
                }
                if (message == '') {
                    arr_errors[1] = '*Поле ОТЗЫВ должно быть заполено';
                }
                if (rating == '') {
                    arr_errors[2] = '*Поле ОЦЕНКА должно быть заполено';
                }
                if (message.length>2000) {
                    arr_errors[3] = '*Текст отзыва не должен превышать 2000 символов';
                }
                if (name.length>255) {
                    arr_errors[4] =  '*Имя автора не должно превышать 255 символов';
                }
                if (rating != '' && (rating>10 || rating<1)) {
                    arr_errors[5] = '*Оценка должна быть числом от 1 до 10';
                }
                if (arr_errors.length == 0) {
                    $.ajax({
                        url: "add_review.php",
                        type: "POST",
                        data: ({name: name, message: message, rating: rating, id: '<?php echo $_GET['id'] ?>'}),
                        dataType: "html",
                        beforeSend: funcBefore,
                        success: funcSuccess
                    });
                } else {
                    $("#name_error").text ("");
                    $("#message_error").text ("");
                    $("#rating_error").text (" ");
                    $("#end_info").text ("Неправильно заполнена форма");
                    if (arr_errors.indexOf('*Поле ИМЯ должно быть заполено') !== -1){
                        $("#name_error").text ("*Поле ИМЯ должно быть заполено");
                    }
                    if (arr_errors.indexOf('*Поле ОТЗЫВ должно быть заполено') !== -1){
                        $("#message_error").text ("*Поле ОТЗЫВ должно быть заполено");
                    }
                    if (arr_errors.indexOf('*Поле ОЦЕНКА должно быть заполено') !== -1){
                        $("#rating_error").text ("*Поле ОЦЕНКА должно быть заполено");
                    }
                    if (arr_errors.indexOf('*Текст отзыва не должен превышать 2000 символов') !== -1){
                        $("#message_error").text ("*Текст отзыва не должен превышать 2000 символов");
                    }
                    if (arr_errors.indexOf('*Имя автора не должно превышать 255 символов') !== -1){
                        $("#name_error").text ("*Имя автора не должно превышать 255 символов");
                    }
                    if (arr_errors.indexOf('*Оценка должна быть числом от 1 до 10') !== -1){
                        $("#rating_error").text ("*Оценка должна быть числом от 1 до 10");
                    }
                }
            });
        });
    </script>
<!--ВЫВОД ОТЗЫВОВ-->
    <?php
        $id_b = $_GET['id'];
        //номер страницы
        if (isset($_GET['page'])){
            $page = $_GET['page'];
        }else $page = 1;
        $previous = $page - 1;
        $next = $page + 1;
        //количество выводимых записей
        $kolvo = 5;
        //номер записи, с которой начинается вывод на странице
        $start = ($page * $kolvo) - $kolvo;
        //количество всех записей
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM reviews where id_book=?');
        $stmt->execute(array($id_b));
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $row = $stmt->fetch();
        $all_record = $row['COUNT(*)'];
        //количетсво страниц
        $str_pag = ceil($all_record / $kolvo);
        $stmt = $pdo->prepare('select author_review, rating, text from reviews where id_book = :id_b  order by id desc limit :start, :kolvo');
        $stmt->execute(array(':id_b' => $id_b, ':start' => $start, ':kolvo' => $kolvo));
        foreach ($stmt as $row) {
            echo "<div class='review'>";
            echo "<b>Имя: </b>" . $row['author_review'] . "<br />";
            echo "<b>Оценка: </b>" . $row['rating'] . "<br  /><div class='line'></div>";
            echo "<b>Отзыв: </b>" . $row['text'] . "<br />";
            echo "</div>";
        }
    ?>
    <nav aria-label="Page navigation" id="pages">
        <ul class="pagination pagination-lg">
            <li class="page-item <?php if ($page == 1){echo "disabled";} ?>">
                <a class="page-link" href="<?php if ($page != 1) {echo "?id=$id_b&page=$previous";} else {echo "#";} ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
            <?php
            for ($i = 1; $i <= $str_pag; $i++){
                if ($page == $i) {
                    $active_page = "active";
                } else {
                    $active_page = '';
                }
                echo "<li class='page-item $active_page'><a class='page-link' href='?id=$id_b&page=$i'>".$i." </a></li>";
            }
            ?>
            <li class="page-item <?php if ($page == $str_pag){echo "disabled";} ?>">
                <a class="page-link" href="<?php if ($page != $str_pag) {echo "?id=$id_b&page=$next";} else {echo "#";}?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
<?php include '../footer.php' ?>
 
 
