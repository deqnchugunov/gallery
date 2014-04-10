<?php

class UserController {

    public function login() {
        if (!$_SESSION['logged']) {
            $view_data['page_title'] = 'Log in';
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                include './models/UserModel.php';
                $user_model = new UserModel();
                $result = $user_model->loginUser($_POST['login'], $_POST['pass']);
                if ($result['success'] && $result['data']) {
                    $_SESSION['logged'] = true;
                    $_SESSION['user_data'] = $result['data'];
                    header('Location: ?');
                    exit;
                } else {
                    $view_data['errors'] = $result['data'];
                }
            }
            View::getInstance()->render('login', $view_data);
        } else {
            header('Location: ?');
        }
    }

    public function logout() {
        session_destroy();
        header('Location: ?');
    }

    public function register() {
        if (!$_SESSION['logged']) {
            $view_data['page_title'] = 'Registration';
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                include './models/UserModel.php';
                $user_model = new UserModel();
                $result = $user_model->registerUser($_POST['login'], $_POST['pass'], $_POST['pass2']);
                if ($result['success'] && $result['data']) {
                    $view_data['success'] = $result['data'];
                } else {
                    $view_data['errors'] = $result['data'];
                }
            }
            View::getInstance()->render('register', $view_data);
        } else {
            header('Location: ?');
        }
    }
}
