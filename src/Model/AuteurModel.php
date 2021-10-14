<?php
namespace App\Model;

use App\Model\ConnexionBdd;
use PDO;

class AuteurModel{

    private $db;

    public function __construct(){
        $instanceConnexion = new ConnexionBdd;
        $this->db = $instanceConnexion->connect();
    }

    //         // $prep->debugDumpParams();  // en cas d'erreurs

    function findAllAuteurs(){
        $requete = "
        SELECT au.nom, au.prenom, au.id, count(oe.id) AS nbrOeuvre
        FROM oeuvre oe
        RIGHT JOIN auteur au ON au.id=oe.auteur_id
        GROUP BY au.nom, au.prenom, au.id
        ORDER BY au.nom;";
        $prep = $this->db->prepare($requete);
        $prep->execute();
        $results= $prep->fetchAll();
        return $results;
    }


    function createAndPersistAuteur($donnees){
        $requete=" INSERT INTO AUTEUR (id,nom,prenom) VALUES
    (NULL,'${donnees['nom']}','${donnees['prenom']}');";
        $nbRes = $this->db->exec($requete);

        // requete préparée présentation : https://gdufrene.github.io/mooc_jee_spring/jdbc.html
        // tester une injection : supprimer Kessel
        //  ');DELETE FROM AUTEUR WHERE id=8;
        //  ');DELETE FROM AUTEUR WHERE id BETWEEN 20 AND 80;

//        $requete=" INSERT INTO AUTEUR (id,nom,prenom) VALUES
//      (NULL,:nom,:prenom);";
//        $prep=$this->db->prepare($requete);
//        $prep->bindParam(':nom',$donnees['nom'],\PDO::PARAM_STR_CHAR);
//        $prep->bindParam(':prenom',$donnees['prenom'],\PDO::PARAM_STR_CHAR);
//        //dd($prep->debugDumpParams());
//        $Res=$prep->execute();
//        return $Res;

        //  The PDOStatement::execute() method returns a boolean value. true if it is successful or false if it fails.
        // tester avec comme nom : aa'bb"cc<dd>ee

// autre solution
//        $requete=" INSERT INTO AUTEUR (id,nom,prenom) VALUES
//      (NULL,?,?);";
//        $res=$this->db->execute([$donnees['nom'],$donnees['prenom']]);
//        // https://www.pierre-giraud.com/php-mysql-apprendre-coder-cours/requete-preparee/

    }


    function removeByIdAuteur($id){
        $requete = "
        DELETE 
        FROM auteur WHERE id=:id LIMIT 1;";
        $prep = $this->db->prepare($requete);
        $prep->bindParam(':id', $id, \PDO::PARAM_INT);
        $Res = $prep->execute();
        return $Res;
    }

    function findOneByIdAuteur($id){
        $requete="
        SELECT id, nom, prenom
        FROM auteur
        WHERE id=:id";
        $prep=$this->db->prepare($requete);
        $prep->bindParam(':id', $id, \PDO::PARAM_INT);
        $prep->execute();
        $result = $prep->fetch();
        return $result;
    }

    function updateAndPersistAuteur($id, $donnees){
        $requete = "
        UPDATE auteur SET 
        nom=:nom,
        prenom=:prenom
        WHERE id = :id";
        $prep = $this->db->prepare($requete);
        $prep->bindParam(':id', $id, \PDO::PARAM_INT);
        $prep->bindParam(':nom', $donnees['nom'], \PDO::PARAM_STR_CHAR);
        $prep->bindParam(':prenom', $donnees['prenom'], \PDO::PARAM_STR_CHAR);
        $Res=$prep->execute();
        return $Res;
    }


    // liste déroulante add/edit OEUVRE

    function findAllDropdownAuteurs(){
        $requete = "
        SELECT id as idAuteur, nom as nomAuteur
        FROM AUTEUR;";
        $prep = $this->db->prepare($requete);
        $prep->execute();
        $result = $prep->fetchAll();
        return $result;
    }
}