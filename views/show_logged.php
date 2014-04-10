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
    <div class="img_preview">
        <img src="./user_pics/<?php echo $data['user_id']; ?>/<?php echo $data['pic_name']; ?>" /><br/>
        <div class="album_name">Album: <?php echo $data['album']; ?>&nbsp;&nbsp;&nbsp;
        User: <?php echo $data['user']; ?>&nbsp;&nbsp;&nbsp;
        Comment: <?php echo (mb_strlen($data['comment']) == 0) ? 'No comment' : $data['comment']; ?></div>
    </div>
</div>
<?php
include './views/footer.php';
