<?php
/**
 * Created by PhpStorm.
 * User: AwH
 * Date: 22/05/15
 * Time: 13:51
 */

namespace Website\Controller;


abstract class MessageFlashController {

    public function __construct(){

    }


    public function addMessage($type, $message){
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