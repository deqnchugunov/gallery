<?php

class IndexController {

    public function index() {
        $view_data['page_title'] = 'Home page';
        include './models/IndexModel.php';
        $index_model = new IndexModel();
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
        $result = $index_model->getIndexPage($page, $num);
        if ($result['success'] === true) {
            $view_data['data'] = $result['data'];
            $view_data['pager'] = $result['pager'];
            if ($_SESSION['logged']) {
                View::getInstance()->render('index_logged', $view_data);
            } else {
                View::getInstance()->render('index', $view_data);
            }
        } else {
            $view_data['data'] = $result['data'];
            View::getInstance()->render('error', $view_data);
        }
    }
}
