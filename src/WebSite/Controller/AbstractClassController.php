<?php

namespace Website\Controller;

use Symfony\Component\Yaml\Yaml;


class AbstractClassController {

    public function getConnexion(){
        $myConfig = Yaml::parse(file_get_contents(__DIR__.'/../../../app/config/config-dev.yml'));

        $config = new \Doctrine\DBAL\Configuration();

        $connectionParams = [
            'dbname' => $myConfig['doctrine']['database'],
            'user' => $myConfig['doctrine']['username'],
            'password' => $myConfig['doctrine']['password'],
            'host' => $myConfig['doctrine']['host'],
            'driver' => $myConfig['doctrine']['driver'],
        ];

        return \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);
    }
}