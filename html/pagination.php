<nav aria-label="Page navigation" id="pages">
    <ul class="pagination pagination-lg">
        <li class="page-item <?php if ($page == 1){echo "disabled";} ?>">
            <a class="page-link" href="<?php if ($filtration == 4 || $filtration == 5 || $filtration == 6) {if ($page !=1) {echo "?page=$previous&filtration=$filtration&id_author=$id_a";} else {echo "#";}} else {if ($page != 1) {echo "?page=$previous&filtration=$filtration";} else {echo "#";} } ?>" aria-label="Previous">
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
            echo "<li class='page-item $active_page'>";
            if ($filtration == 4 || $filtration == 5 || $filtration == 6) {
                echo "<a class='page-link' href='?page=$i&filtration=$filtration&id_author=$id_a'>";
            } else {
                echo "<a class='page-link' href='?page=$i&filtration=$filtration'>";
            }
            echo $i . " </a></li>";
        }
        ?>
        <li class="page-item <?php if ($page == $str_pag){echo "disabled";} ?>">
            <a class="page-link" href="<?php if ($filtration == 4 || $filtration == 5 || $filtration == 6) {if ($page != $str_pag) {echo "?page=$next&filtration=$filtration&id_author=$id_a";} else {echo "#";}} else {if ($page != $str_pag) {echo "?page=$next&filtration=$filtration";} else {echo "#";} }?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
            </a>
        </li>
    </ul>
</nav>