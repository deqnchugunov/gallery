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
foreach ($data as $value) {
    ?>
    <div id="picture">
        <a href="?p=show&id=<?php echo $value['pictures_id']; ?>">
            <img class="pic_info" src="./user_pics/<?php echo $value['users_id']; ?>/thumb_<?php echo $value['name']; ?>" />
        </a>
        <div class="pic_info_name"><span><?php echo $value['comment']; ?></span></div>
    </div>
    <?php
}
?>
<div class="clear"></div>
</div>
<?php
include './views/footer.php';
