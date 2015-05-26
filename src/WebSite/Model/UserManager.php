<?php

namespace Website\Model;

class UserManager {

    public function __construct($param){
        $this->bdd = $param;
    }

    public function listUser(){
        $statement = $this->bdd->prepare('SELECT * FROM users');
        $statement->execute();

        return $statement->fetchAll();

    }

    function showUser($id){
        $statement = $this->bdd->prepare('SELECT * FROM users WHERE id = :id');
        $statement->execute([
            'id' => $id
        ]);

        return $statement->fetch();
    }

    public function addUser($name, $pass){
        $statement = $this->bdd->prepare("INSERT INTO users (name, password, inscription_date) VALUES (:name, :password, NOW())");
        $statement->execute([
            'name' => $name,
            'password' => sha1($pass),
        ]);
    }

    public function logUser($name, $pass){
        $statement = $this->bdd->prepare('SELECT * FROM users WHERE name = :name AND password = :password');
        $statement->execute([
            'name' => $name,
            'password' => sha1($pass),
        ]);

        return $statement->fetch();
    }

    public function deleteUser(){

    }

    public function countUserByName($name){
        $statement = $this->bdd->prepare('SELECT COUNT(*) as user FROM users WHERE name = :name');
        $statement->execute([
            'name' => $name
        ]);

        return $statement->fetch();
    }

    public function countUserByNameAndPassword($name, $pass){
        $statement = $this->bdd->prepare('SELECT COUNT(*) as user FROM users WHERE name = :name AND password = :password');
        $statement->execute([
            'name' => $name,
            'password' => sha1($pass),
        ]);

        return $statement->fetch();
    }

}