<?php

if(empty($_GET['id'])){
    echo 'merci de spécifié un id dans l\'url: /index.php?p=show_user&id={ID}';
} else {

    $user->showUserAction($request['query']['id']);

// var_dump($user->showUserAction($request['query']['id'])['user']);


    echo '<h1>Show User\'s</h1>';


    echo 'id : '.$user->showUserAction($request['query']['id'])['user']['id'].'<br />';
    echo 'Username : '.$user->showUserAction($request['query']['id'])['user']['name'].'<br />';
    echo 'email : '.$user->showUserAction($request['query']['id'])['user']['email'].'<br />';
    echo 'Date d\'inscription : '.$user->showUserAction($request['query']['id'])['user']['inscription_date'];

}