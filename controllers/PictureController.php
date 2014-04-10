<?php

class PictureController {

    public function upload() {
        if ($_SESSION['logged']) {
            $view_data['page_title'] = 'Upload';

            include './models/PictureModel.php';
            $pic_model = new PictureModel();

            $res = $pic_model->getUserAlbums($_SESSION['user_data']['users_id']);
            $view_data['albums'] = $res['data'];

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $result = $pic_model->uploadPicture($_POST['album'], $_FILES['filename'], $_POST['desc'], $_POST['public'], $_SESSION['user_data']['users_id']);
                if ($result['success'] && $result['data']) {
                    $view_data['success'] = $result['data'];
                } else {
                    $view_data['errors'] = $result['data'];
                }
            }
            View::getInstance()->render('upload', $view_data);
        } else {
            header('Location: ?');
        }
    }

    public function show() {
        $view_data['page_title'] = 'Picture preview';

        include './models/PictureModel.php';
        $pic_model = new PictureModel();

        if ($_SESSION['logged']) {
            $res = $pic_model->showPicture($_GET['id'], $_SESSION['user_data']['users_id']);
            $template = 'show_logged';
        } else {
            $res = $pic_model->showPicture($_GET['id']);
            $template = 'show';
        }
        $view_data['data'] = $res['data'];
        View::getInstance()->render($template, $view_data);
    }

    public function albums() {
        if ($_SESSION['logged']) {

            include './models/PictureModel.php';
            $pic_model = new PictureModel();

            if (isset($_GET['action']) && $_GET['action'] == 'add') {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $result = $pic_model->addAlbum($_SESSION['user_data']['users_id'], $_POST['name']);
                    if ($result['success'] && $result['data']) {
                        $view_data['success'] = $result['data'];
                    } else {
                        $view_data['errors'] = $result['data'];
                    }
                }
                $view_data['page_title'] = 'Add album';
                $template = 'add_album';
                $res = $pic_model->getUserAlbums($_SESSION['user_data']['users_id']);
                $view_data['data'] = $res['data'];
            } else if (isset($_GET['action']) && $_GET['action'] == 'edit') {
                $view_data['page_title'] = 'Edit album';
                $template = 'edit';
                $res = $pic_model->getUserAlbums($_SESSION['user_data']['users_id']);
                $view_data['data'] = $res['data'];
            } else if (isset($_GET['action']) && $_GET['action'] == 'edit_album' && isset($_GET['id'])) {
                $view_data['page_title'] = 'Edit album';
                $template = 'edit_album';
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $query = $pic_model->editAlbum($_SESSION['user_data']['users_id'], $_POST['name'], $_GET['id']);
                    if ($query['success'] && $query['data']) {
                        $view_data['success'] = $query['data'];
                    } else {
                        $view_data['errors'] = $query['data'];
                    }
                }
                $result = $pic_model->getAlbumName($_GET['id'], $_SESSION['user_data']['users_id']);
                if ($result['success'] && $result['data']) {
                    $view_data['data'] = $result['data'];
                } else {
                    $view_data['page_title'] = 'Edit album';
                    $template = 'error';
                    $view_data['data'] = $result['data'];
                }
            } else if (isset($_GET['action']) && $_GET['action'] == 'delete') {
                if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id']) && $_GET['id'] > 0) {
                    $query = $pic_model->deleteAlbum($_GET['id'], $_SESSION['user_data']['users_id']);
                    if ($query['success'] && $query['data']) {
                        $view_data['success'] = $query['data'];
                    } else {
                        $view_data['errors'] = $result['data'];
                    }
                }
                $view_data['page_title'] = 'Delete album';
                $template = 'delete';
                $res = $pic_model->getUserAlbums($_SESSION['user_data']['users_id']);
                $view_data['data'] = $res['data'];
            } else if (isset($_GET['album_id']) && $_GET['album_id'] > 0) {
                $view_data['page_title'] = 'Album preview';
                $template = 'album';
                $res = $pic_model->getAlbumContent($_GET['album_id'], $_SESSION['user_data']['users_id']);
                $view_data['data'] = $res['data'];
            } else {
                if (isset($_GET['page'])) {
                    $page = (int) $_GET['page'];
                } else {
                    $page = 1;
                }
                if (isset($_GET['num'])) {
                    $num = (int) $_GET['num'];
                } else {
                    $num = 10;
                }
                $view_data['page_title'] = 'Albums';
                $template = 'albums';
                $res = $pic_model->getUserAlbums($_SESSION['user_data']['users_id'], $page, $num);
                $view_data['data'] = $res['data'];
            }
            View::getInstance()->render($template, $view_data);
        } else {
            header('Location: ?');
        }
    }

}
