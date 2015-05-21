<form method="POST">
    <label for="username">Username :</label><input type="text" name="username" id="username" required/><br />
    <label for="pwd">Password :</label><input type="password" name="pwd" id="pwd" required/><br />
    <input type="submit"/>
</form>
<?php

if(!empty($_POST['username']) && !empty($_POST['pwd'])){
    $user->logUserAction($request);
    var_dump($_SESSION);
} else {
    echo '<a href="?p=add_user">Inscription</a>';
}