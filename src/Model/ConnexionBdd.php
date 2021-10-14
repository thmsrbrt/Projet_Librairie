<?php
namespace App\Model;

use PDO;

require_once ('config.php');

class ConnexionBdd{

//    private static $instanceBDD;


    public function connect(){

        $dsn = 'mysql:host='.hostname.';dbname='.database.';charset=utf8';
        $ma_connexion_mysql = new PDO($dsn, username, password);
       // var_dump('connexion : '.uniqid());
        $ma_connexion_mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $ma_connexion_mysql->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $ma_connexion_mysql;


        // partern singleton
        // * **Objectif** :Obliger une instance particulière d'une application à être unique dans toute la portée de l'application.
        //* Problème : Unicité d'une ressource utilitaire
        // Si une application a besoin d'un descripteur d'une ressource "unique".
        // Cette ressource sert de référence pour obtenir un certain nombre de services. Il est nécessaire de pouvoir s'assurer de cette unicité,
        // et s'assurer que l'ensemble des développeurs qui contribuent à l'écriture du programme utilisent bien la seule instance disponible.
        // https://apprendre-php.com/tutoriels/tutoriel-45-singleton-instance-unique-d-une-classe.html

//        if(! isset(ConnexionBdd::$instanceBDD)){
//            $dsn = 'mysql:host='.hostname.';dbname='.database.';charset=utf8';
//            $ma_connexion_mysql = new \PDO($dsn, username, password);
//            var_dump('connexion : '.uniqid());
//            $ma_connexion_mysql->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
//            $ma_connexion_mysql->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE,\PDO::FETCH_ASSOC);
//            ConnexionBdd::$instanceBDD=$ma_connexion_mysql;
//            return ConnexionBdd::$instanceBDD;
//        }
//        else {
//            return ConnexionBdd::$instanceBDD;
//        }


    }
}
