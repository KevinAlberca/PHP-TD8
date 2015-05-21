<?php
/**
 * Created by PhpStorm.
 * User: nico
 * Date: 23/04/2015
 * Time: 23:45
 */

namespace Website\Controller;


/**
 * Class UserController
 *
 * Controller of all User actions
 *
 * @package Website\Controller
 */
class UserController extends AbstractClassController {


    /**
     * Recup all users and print it
     *
     * @return array
     */
    public function listUserAction() {

        $statement = $this->getConnexion()->prepare('SELECT * FROM users');


        $statement->execute();
        $users = $statement->fetchAll();

        //you can return a Response object
        return [
            'view' => 'WebSite/View/user/listUser.html.php', // should be Twig : 'WebSite/View/user/listUser.html.twig'
            'users' => $users
        ];
    }


    /**
     * show one user thanks to his id : &id=...
     *
     * @return array
     */
    public function showUserAction($request) {
        $statement = $this->getConnexion()->prepare('SELECT * FROM users WHERE id = :id');
        @$statement->execute([
            'id' => $request,
        ]);

        $user = $statement->fetch();


        //you can return a Response object
        return [
            'view' => 'WebSite/View/user/showUser.html.php', // should be Twig : 'WebSite/View/user/listUser.html.twig'
            'user' => $user
        ];
    }

    /**
     * Add User and redirect on listUser after
     */
    public function addUserAction($request) {
        //Use Doctrine DBAL here
        if ($request['request']) { //if POST
# Check if username or email is already exist in DB
            $check = $this->getConnexion()->prepare('SELECT COUNT(*) as user FROM users WHERE name = :name');
            $check->execute([
                'name' => $request['request']['username'],
            ]);

            $row = $check->fetch();

            if($row['user'] == 0){
# Any users exist, we can register this username
                $statement = $this->getConnexion()->prepare('INSERT INTO users(name, password, inscription_date) VALUES (:name, :password, :inscription_date)');
                $statement->execute([
                    'name' => $request['request']['username'],
                    'password' => sha1($request['request']['pwd']),
                    'inscription_date' => date('Y-m-d H:i:s'),
                ]);

                return [
                    'redirect_to' => '?p=log_user',
                ];
            }
        }
        //you should return a Response object
        return [
            'view' => 'WebSite/View/user/addUser.html.php',
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
                $this->addMessageFlash('error', 'Aucun utilisateur n\'a été trouvé');
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


    private function addMessageFlash($type, $message){
        // autorise que 4 types de messages flash
        $types = ['success','error','alert','info'];
        if (!in_array($type, $types)) {
            return false;
        }
        // on vérifie que le type existe
        if (!isset($_SESSION['flashBag'][$type])) {
            //si non on le créé avec un Array vide
            $_SESSION['flashBag'][$type] = [];
        }
        // on ajoute le message
        $_SESSION['flashBag'][$type][] = $message;
    }
}
