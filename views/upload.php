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
        <div id="title">Upload picture</div><br />
        <form action="?p=upload" method="POST" enctype="multipart/form-data">
            <div class="singleLine">
                <span class="textInfo">Album</span>
                <select class="selectCss" name="album">
                    <?php
                    foreach ($albums as $key => $v) {
                        echo '<option value="' . $key . '">' . $v . '</option>';
                    }
                    ?>
                </select>
                <span class="error">
                    <?php
                    if (isset($errors['album'])) {
                        echo $errors['album'];
                    }
                    ?>
                </span>
            </div>
            <div class="singleLine">
                <span class="textInfo">File</span>
                <input type="file" name="filename" />
                <span class="error">
                    <?php
                    if (isset($errors['file'])) {
                        echo $errors['file'];
                    }
                    ?>
                </span>
            </div>
            <div class="singleLine">
                <span class="textInfo">Description</span>
                <span id="name"><textarea name="desc" id="styled"></textarea></span>
                <span class="error">
                    <?php
                    if (isset($errors['description'])) {
                        echo $errors['description'];
                    }
                    ?>
                </span>
            </div>
            <div class="singleLine">
                <span class="textInfo">Public</span><input type="checkbox" name="public" value="1"/> <span>(check it for public)</span>
            </div>
            <div class="singleLine">
                <span id="name"><input class="submitLoginForm" type="submit" value="Upload" /></span>
            </div>

        </form>
        <div class="error">
            <?php
            if (isset($errors['size'])) {
                echo $errors['size'];
            }
            ?>
        </div>
        <div class="error">
            <?php
            if (isset($errors['type'])) {
                echo $errors['type'];
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
