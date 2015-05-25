<?php
    $user->showUserAction($request);

    echo '<h1>Show User\'s</h1>';


    echo 'id : '.$user->showUserAction($request)['user']['id'].'<br />';
    echo 'Username : '.$user->showUserAction($request)['user']['name'].'<br />';
    echo 'Date d\'inscription : '.$user->showUserAction($request)['user']['inscription_date'];
