<?php


namespace Website\Controller;


class HomeController {

    public function homeAction(){
        return [
            'view' => '/../src/WebSite/View/home/home.html.php',
        ];
    }
}