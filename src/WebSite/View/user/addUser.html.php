<form method="POST">
    <label for="username">Name :</label><input type="text" name="username" id="username" required /><br />
    <label for="pwd">password :</label><input type="password" name="pwd" id="pwd" required /><br />
    <label for="pwdCheck">password check :</label><input type="password" name="pwdCheck" id="pwdCheck" required /><br />
    <label for="useremail">email :</label><input type="text" name="useremail" id="useremail" value="<?php echo mt_rand(0, 10000000).'@email.com'; ?>" required /><br />
    <input type="submit" value="Inscription" />
</form>
<?php

@$username = $_POST['username'];
@$pwd = $_POST['pwd'];
@$pwdCheck = $_POST['pwdCheck'];
@$useremail = $_POST['useremail'];

if(isset($username, $pwd, $pwdCheck, $useremail)){
    if($pwd == $pwdCheck){
# Begin the registration process
        $user->addUserAction($request);

        var_dump($user->addUserAction($request));

        if($user->addUserAction($request)['user'] == 0){
            echo 'Le compte a été créé';
        } else {
            echo 'Le compte n\'a pas pu être créé';
        }

    } else {
        echo 'Votre mot de passe de vérification n\' est pas identique que celui rentré dans le champ mot de passe';
    }
}