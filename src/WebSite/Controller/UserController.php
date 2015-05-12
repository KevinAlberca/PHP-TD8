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
class UserController {

    /**
     * Recup all users and print it
     *
     * @return array
     */
    public function listUserAction($request) {
        //Use Doctrine DBAL here

        /*****/
        $config = new \Doctrine\DBAL\Configuration();


        //for this array use config_dev.yml and YamlComponents
        // http://symfony.com/fr/doc/current/components/yaml/introduction.html
        $connectionParams = array(
            'dbname' => 'mydb',
            'user' => 'user',
            'password' => 'secret',
            'host' => 'localhost',
            'driver' => 'pdo_mysql',
        );
        
        $conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);

        // http://docs.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/data-retrieval-and-manipulation.html
        // it's much better if you use QueryBuilder : http://docs.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/query-builder.html
        $statement = $conn->prepare('SELECT * FROM user');


        $statement->execute();
        $users = $statement->fetchAll();
/******/     

        //you can return a Response object
        return [
            'view' => 'WebSite/View/user/listUser.html.php', // should be Twig : 'WebSite/View/user/listUser.html.twig'
            'users' => $users
        ];
    }


    /**
     * swho one user thanks to his id : &id=...
     *
     * @return array
     */
    public function showUserAction($request) {
        //Use Doctrine DBAL here

        $user = ...

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
            //handle form with DBAL
            //...

            //Redirect to show
            //you should return a RedirectResponse object
            return [
                'redirect_to' => 'http://.......',// => manage it in index.php !! URL should be generate by Routing functions thanks to routing config

            ];
        }


        //you should return a Response object
        return [
            'view' => 'WebSite/View/user/addUser.html.php',// => create the file
            'user' => $user
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
