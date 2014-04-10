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
        <form action="?p=albums&action=edit_album&id=<?php echo $data['id']; ?>" method="POST">
            <span id="name">Name</span>
            <span><input class="inputLoginForm" type="text" name="name" value="<?php echo $data['name']; ?>"/></span>
            <span><input class="submitLoginForm" type="submit" value="Edit" /></span>
        </form><br />
        <div class="error">
            <?php
            if (isset($errors['name'])) {
                echo $errors['name'];
            }
            ?>
        </div>
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
    </div>
</div>
<?php
include './views/footer.php';
