<?php
include './views/header.php';
?>
<div id="header">
    <div id="top">
        <div id="img">
            <div id="logo"><a href="?"><img src="./img/sg.png" /></a></div>
        </div>
    </div>
    <div id="bottom">
        <div id="nav">
            <div id="left">
                <ul class="dropdown">
                    <li><a href="?">Home</a></li>
                    <li><a href="?p=upload">Upload</a></li>
                    <li><a href="?p=albums">Albums</a>
                        <ul>
                            <li><a href="?p=albums&action=add">Add album</a></li>
                            <li><a href="?p=albums&action=edit">Edit album</a></li>
                            <li><a href="?p=albums&action=delete">Delete album</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div id="right"><a href="?p=profil"><?php echo $_SESSION['user_data']['login'] ?></a><a href="?p=logout">Logout</a></div>
        </div>
    </div>
</div>
<div id="content">
    <?php
    echo '<div class="pics-per-page">';
    echo '<span>Pictures per page: </span><a href="?page=1&num=10">10</a><a href="?page=1&num=15">15</a><a href="?page=1&num=20">20</a>';
    echo '</div>';
    for ($w = $pager['startRes']; $w <= $pager['endRes']; $w++) {
        ?>
        <div id = "picture">
            <a href = "?p=show&id=<?php echo $data[$w]['pictures_id']; ?>">
                <img class = "pic_info" src = "./user_pics/<?php echo $data[$w]['users_id']; ?>/thumb_<?php echo $data[$w]['name']; ?>" />
            </a>
            <div class = "pic_info_name"><span><?php echo $data[$w]['comment'];
        ?></span></div>
        </div>
        <?php
    }
    echo '    <div class="clear"></div>';
    echo '<div class="pager">';
    if ($pager['page'] > 1) {
        echo '<a href="?page=1&num=' . $pager['per_page'] . '">first</a><span>&nbsp;&nbsp;</span>';
        echo '<a href="?page=' . $pager['prev'] . '&num=' . $pager['per_page'] . '">prev</a><span>&nbsp;&nbsp;</span>';
    } else {
        echo '<span class="pager-inactive">first</span><span>&nbsp;&nbsp;</span>';
        echo '<span class="pager-inactive">prev</span><span>&nbsp;&nbsp;</span>';
    }

    for ($t = $pager['startIndex']; $t <= $pager['endIndex']; $t++) {
        if ($t == $pager['page']) {
            echo "[";
        }
        echo '<span>   </span><a href="?page=' . $t . '&num=' . $pager['per_page'] . '">' . $t . '</a><span>   </span>';
        if ($t == $pager['page']) {
            echo "]";
        }
    }

    if ($pager['page'] < $pager['all_pages']) {
        echo '<span>&nbsp;&nbsp;</span><a href="?page=' . $pager['next'] . '&num=' . $pager['per_page'] . '">next</a>';
        echo '<span>&nbsp;&nbsp;</span><a href="?page=' . $pager['all_pages'] . '&num=' . $pager['per_page'] . '">last</a>';
    } else {
        echo '<span>&nbsp;&nbsp;</span><span class="pager-inactive">next</span>';
        echo '<span>&nbsp;&nbsp;</span><span class="pager-inactive">last</span>';
    }
    echo '</div>';
    ?>
    <div class="clear"></div>
</div>
<?php
include './views/footer.php';
