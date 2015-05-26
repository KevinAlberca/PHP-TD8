<?php

namespace Website\Controller;

use Symfony\Component\Yaml\Yaml;


class AbstractClassController {


    public function getConnexion(){
        $myConfig = Yaml::parse(file_get_contents(__DIR__.'/../../../app/config/config-dev.yml'));
        return \Doctrine\DBAL\DriverManager::getConnection($myConfig['doctrine'], new \Doctrine\DBAL\Configuration());
    }

    protected function getUserManager() {
        return new \Website\Model\UserManager($this->getConnection());
    }

}