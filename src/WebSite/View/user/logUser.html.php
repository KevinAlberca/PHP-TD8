<?php
if(isset($_SESSION['user']) && !empty($_SESSION['user'])){
    header('Location: ./?p=home');
} else { ?>
    <head>
        <meta charset="utf-8"/>
    </head>
    <form method="POST">
        <label for="name">Username :</label><input type="text" name="name" id="name" required/><br/>
        <label for="pwd">Password :</label><input type="password" name="pwd" id="pwd" required/><br/>
        <input type="submit"/>
    </form>
    <?php

    if (!empty($_POST['name']) && !empty($_POST['pwd'])) {
        $user->logUserAction($request);
    } else {
        echo '<a href="?p=add_user">Inscription</a>';
    }

    if (isset($_SESSION['flashBag'])) {
        foreach ($_SESSION['flashBag'] as $type => $flash) {
            foreach ($flash as $key => $message) {
                echo '<div class="' . $type . '" role="' . $type . '" >' . $message . '</div>';
                // un fois affiché le message doit être supprimé
                unset($_SESSION['flashBag'][$type][$key]);
            }
        }
    }
}