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
            <div id="right"></div>
        </div>
    </div>
</div>
<div id="content">
    <div class="album_name"><?php echo $data; ?></div>
</div>
<?php
include './views/footer.php';
