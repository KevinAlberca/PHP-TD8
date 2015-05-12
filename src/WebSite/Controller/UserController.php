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
    public function listUserAction($request) {

        $statement = $this->getConnexion()->prepare('SELECT * FROM users');


        $statement->execute();
        $users = $statement->fetchAll();

        //you can return a Response object
        return [
            'view' => 'WebSite/View/user/listUser.html.twig', // should be Twig : 'WebSite/View/user/listUser.html.twig'
            'users' => $users
        ];
    }


    /**
     * swho one user thanks to his id : &id=...
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
    public function addUser($request) {
        //Use Doctrine DBAL here
        if ($request['request']) { //if POST
# Check if username or email is already exist in DB
            $check = $this->getConnexion()->prepare('SELECT COUNT(*) as user FROM users WHERE name = :name OR email = :email');
            $check->execute([
                'name' => $request['request']['username'],
                'email' => $request['request']['useremail'],
            ]);

            $row = $check->fetch();

            var_dump($row);
            if($row['user'] == 0){
# Any users exist, we can register this username
                $statement = $this->getConnexion()->prepare('INSERT INTO users(name, password, email, inscription_date) VALUES (:name, :password, :email, :inscription_date)');
                $statement->execute([
                    'name' => $request['request']['username'],
                    'password' => sha1($request['request']['pwd']),
                    'email' => $request['request']['useremail'],
                    'inscription_date' => date('Y-m-d H:i:s'),
                ]);

                return [
                    'redirect_to' => '?p=log_user',
                ];
            } else {

            }
        }
        //you should return a Response object
        return [
            'user' => @$row['user'],
            'view' => 'WebSite/View/user/addUser.html.php',
        ];
    }


    /**
     * Delete User and redirect on listUser after
     */
    public function deleteUser($request) {
        //Use Doctrine DBAL here



        //you should return a RedirectResponse object , redirect to list
        return [
            'redirect_to' => 'http://.......',// => manage it in index.php !! URL should be generate by Routing functions thanks to routing config

        ];
    }

    /**
     * Log User (Session) , add session in $request first (index.php)
     */
    public function logUser($request) {
        if ($request['request']) { //if POST
            //handle form with DBAL
            //...


        }


        //take FlashBag system from
        // https://github.com/NicolasBadey/SupInternetTweeter/blob/master/model/functions.php
        // line 87 : https://github.com/NicolasBadey/SupInternetTweeter/blob/master/index.php
        // and manage error and success

        //Redirect to list or home
        //you should return a RedirectResponse object
        return [
            'redirect_to' => 'http://.......',// => manage it in index.php !! URL should be generate by Routing functions thanks to routing config

        ];

    }
}
