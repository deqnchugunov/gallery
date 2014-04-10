<?php

error_reporting(E_ALL ^ E_NOTICE);
session_start();
include './system/Config.php';
include './system/View.php';

if (isset($_GET['p'])) {
    $current_page = $_GET['p'];
} else {
    $current_page = 'index';
}
switch ($current_page) {
    case 'index':
        include './controllers/IndexController.php';
        $page = new IndexController();
        $page->index();
        break;
    case 'register':
        include './controllers/UserController.php';
        $page = new UserController();
        $page->register();
        break;
    case 'login':
        include './controllers/UserController.php';
        $page = new UserController();
        $page->login();
        break;
    case 'logout':
        include './controllers/UserController.php';
        $page = new UserController();
        $page->logout();
        break;
    case 'upload':
        include './controllers/PictureController.php';
        $page = new PictureController();
        $page->upload();
        break;
    case 'show':
        include './controllers/PictureController.php';
        $page = new PictureController();
        $page->show();
        break;
    case 'albums':
        include './controllers/PictureController.php';
        $page = new PictureController();
        $page->albums();
        break;
    default:
        View::getInstance()->render('404', array('page_title' => 'Error'));
        break;
}
