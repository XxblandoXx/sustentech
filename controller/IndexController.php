<?php


class IndexController extends Controller {

    public function index() {
        $this->check_permission(true);

        require(PATH_VIEW . '_includes/header.php');
        require(PATH_VIEW . 'index.php');
        require(PATH_VIEW . '_includes/footer.php');
    }
    
}