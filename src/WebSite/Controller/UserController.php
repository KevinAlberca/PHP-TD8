<?php

namespace Website\Controller;
use Website\Model\UserManager;


/**
 * Class UserController
 *
 * Controller of all User actions
 *
 * @package Website\Controller
 */
class UserController extends AbstractClassController {


    public function __construct(){

    }

    /**
     * Recup all users and print it
     *
     * @return array
     */

    public function listUserAction() {
        $userManager = new UserManager($this->getConnexion());
        $user = $userManager->listUser();

        return [
            'view' => 'WebSite/View/user/listUser.html.php', // should be Twig : 'WebSite/View/user/listUser.html.twig'
            'users' => $user
        ];
    }


    /**
     * show one user thanks to his id : &id=...
     *
     * @return array
     */
    public function showUserAction($request) {
        $userManager = new UserManager($this->getConnexion());
        $user = $userManager->showUser($request['query']['id']);

        return [
            'view' => 'WebSite/View/user/showUser.html.php',
            'user' => $user
        ];
    }

    /**
     * Add User and redirect on listUser after
     */
    public function addUserAction($request){
        if($request['request']) {
            $userManager = new UserManager($this->getConnexion());
            $check = $userManager->countUserByName($request['request']['name']);

            if($check['user'] == 0) {
                $userManager->addUser($request['request']['name'], $request['request']['pwd']);
                return [
                    'redirect_to' => '?p=list_user',
                ];
            }
        }
        return [
            'view' => '../src/WebSite/View/user/addUser.html.php',
        ];
    }


    /**
     * Delete User and redirect on listUser after
     */
    public function deleteUserAction($request) {
        //Use Doctrine DBAL here
        if($request){

            $statement = $this->getConnexion()->prepare('DELETE FROM users WHERE id = :id');
            $statement->execute([
               'id' => $request['session']['user']['id'],
            ]);

            //you should return a RedirectResponse object , redirect to list
            return [
                'redirect_to' => '?p=logout_user',// => manage it in index.php !! URL should be generate by Routing functions thanks to routing config
            ];
        }
    }

    /**
     * Log User (Session) , add session in $request first (index.php)
     */

    public function logUserAction($request) {
        if ($request['request']) { //if POST
# Check if username or email is already exist in DB
            $check = $this->getConnexion()->prepare('SELECT COUNT(*) as user FROM users WHERE name = :name AND password = :password');
            $check->execute([
                'name' => $request['request']['username'],
                'password' => sha1($request['request']['pwd']),
            ]);

            $row = $check->fetch();

            if($row['user'] == 1){
# The user exist, we can connect him
                $req = $this->getConnexion()->prepare('SELECT * FROM users WHERE name = :name AND password = :password');
                $req->execute([
                    'name' => $request['request']['username'],
                    'password' => sha1($request['request']['pwd']),
                ]);

                $request['session']['user'] = $req->fetch();
                return [
                   'redirect_to' => '?p=home',
                ];

            } else {
                MessageFlashController::addMessage('error', 'Aucun utilisateur n\'a été trouvé');
            }
        }
        return [
            'view' => 'WebSite/View/user/logUser.html.php',
        ];
    }

    public function logOutUserAction(){
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
            $request['session'] = [];
            return [
                'redirect_to' => '?p=home',
            ];
        }
    }

}
