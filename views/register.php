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
                </ul>
            </div>
            <div id="right"><a href="?p=login">Log in</a><a href="?p=register">Registration</a></div>
        </div>
    </div>
</div>
<div id="content">
    <div id="login">
        <div id="title">Registration</div><br />
        <form action="?p=register" method="POST">
            <div class="singleLine"><span class="textInfo">Login</span>
                <input class="textAreaField" type="text" placeholder="username" name="login" />
                <span class="error">
                    <?php
                    if (isset($errors['user'])) {
                        echo $errors['user'];
                    }
                    ?>
                </span>
            </div>
            <div class="singleLine"><span class="textInfo">Password </span>
                <input class="textAreaField" type="password" placeholder="password" name="pass" />
                <span class="error">
                    <?php
                    if (isset($errors['pass'])) {
                        echo $errors['pass'];
                    }
                    ?>
                </span>
            </div>
            <div class="singleLine"><span class="textInfo">Repeat password</span>
                <input class="textAreaField" type="password" placeholder="password" name="pass2" />
                <span class="error">
                    <?php
                    if (isset($errors['pass2'])) {
                        echo $errors['pass2'];
                    }
                    ?>
                </span>
            </div>
            <div class="singleLine"><input class="submitLoginForm" type="submit" value="Register" /></div>
        </form>
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


