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
    <div id="upload">
        <div id="title">Edit album</div><br />
        <?php
        $number = 1;
        foreach ($data as $key => $v) {
            echo '<span class="edit-row">' . $number . '.</span><span class="edit-row">' . $v . '</span><span class="edit-row-btn"><a href="?p=albums&action=edit_album&id='. $key .'">Edit</a></span><br />';
            $number++;
        }
        ?>
    </div>
</div>
<?php
include './views/footer.php';

