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
        <div id="title">Delete album</div>
        <div class="error">
            <?php
            if (isset($errors['msg'])) {
                echo $errors['msg'];
            }
            ?>
        </div>
        <div class="success">
            <?php
            if (isset($success['msg'])) {
                echo $success['msg'];
            }
            ?>
        </div>
        <?php
        $number = 1;
        foreach ($data as $key => $v) {
            echo '<span class="edit-row">' . $number . '.</span><span class="edit-row">' . $v . '</span><span class="edit-row-btn"><a href="?p=albums&action=delete&id=' . $key . '" onclick="return confirm(\'Are you sure you want to delete the album ?\')">Delete</a></span><br />';
            $number++;
        }
        ?>
    </div>
</div>
<?php
include './views/footer.php';
