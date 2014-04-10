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
    <div id="albums">
        <?php
        echo '<div class="pics-per-page">';
        echo '<span>Albums per page: </span><a href="?page=1&num=10">10</a><a href="?page=1&num=15">15</a><a href="?page=1&num=20">20</a>';
        echo '</div>';
        foreach ($data as $key => $value) {
            if ($key == 0) {
                $image = '<span></span>';
            } else {
                $image = '<a href="?p=albums&album_id=' . $key . '"><div class="img_album"><img src="./img/album.jpg" /></div></a>';
            }
            ?>
            <div class="album">
                <div class="title"><?php echo $value; ?></div>
                <div><?php echo $image; ?></div>
            </div>
            <?php
        }
        ?>
        <div class="clear"></div>
    </div>
</div>
<?php
include './views/footer.php';
