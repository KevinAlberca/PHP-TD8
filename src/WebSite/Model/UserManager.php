<?php

namespace Website\Model;

class UserManager {

    public function __construct($param){
        $this->bdd = $param;
    }

    public function listUser(){
        $this->bdd->prepare('SELECT * FROM users');

    }

    function showUser($id){
        $statement = $this->bdd->prepare('SELECT * FROM users WHERE id = :id');
        @$statement->execute([
            'id' => $id
        ]);

        return $statement->fetch();
    }

    public function addUser(){

    }

    public function logUser(){

    }

    public function deleteUser(){

    }

}