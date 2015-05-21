<?php
    $user->showUserAction($request['session']['user']['id']);

    echo '<h1>Show User\'s</h1>';


    echo 'id : '.$user->showUserAction($request['session']['user']['id'])['user']['id'].'<br />';
    echo 'Username : '.$user->showUserAction($request['session']['user']['id'])['user']['name'].'<br />';
    echo 'Date d\'inscription : '.$user->showUserAction($request['session']['user']['id'])['user']['inscription_date'];
