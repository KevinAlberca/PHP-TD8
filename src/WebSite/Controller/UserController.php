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
        if($request['request']) {
            $userManager = new UserManager($this->getConnexion());
            $check = $userManager->countUserByNameAndPassword($request['request']['name'], $request['request']['pwd']);

            if($check['user'] == 1) {
                $log = $userManager->logUser($request['request']['name'], $request['request']['pwd']);

                $_SESSION['user'] = $log;

                return [
                    'redirect_to' => '?p=list_user',
                    'view' => '../src/WebSite/View/user/logUser.html.php',
                ];
            }
        }
        return [
            'view' => '../src/WebSite/View/user/logUser.html.php',
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
