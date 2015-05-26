<?php
    if(isset($_SESSION['user']) && !empty($_SESSION['user'])){
        header('Location: ./?p=home');
    } else { ?>
<head>
    <meta charset="utf-8"/>
</head>
        <form method="POST">
            <label for="name">Name :</label><input type="text" name="name" id="name" required/><br/>
            <label for="pwd">password :</label><input type="password" name="pwd" id="pwd" required/><br/>
            <label for="pwdCheck">password check :</label><input type="password" name="pwdCheck" id="pwdCheck" required/><br/>
            <input type="submit" value="Inscription"/>
        </form>
        <?php
        @$name = $_POST['name'];
        @$pwd = $_POST['pwd'];
        @$pwdCheck = $_POST['pwdCheck'];


        if (isset($name, $pwd, $pwdCheck)) {
            if ($pwd == $pwdCheck) {
# Begin the registration process
                if($user->addUserAction($request)) {
                    echo 'Le compte a été créé';
                } else {
                    echo 'Le compte n\'a pas pu être créé';
                }

            } else {
                echo 'Votre mot de passe de vérification n\' est pas identique que celui rentré dans le champ mot de passe';
            }
        } else {
            echo '<a href="?p=log_user">Connexion</a>';
        }

    }