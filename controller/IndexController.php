<?php


class IndexController extends Controller {

    public function index() {
        require(PATH_VIEW . '_includes/header.php');
        require(PATH_VIEW . 'index.php');
        require(PATH_VIEW . '_includes/footer.php');
    }
    
}