<?php
namespace App\Model;

use App\Model\ConnexionBdd;

class ExemplaireModel{

    private $db;

    public function __construct(){
        $instanceConnexion = new ConnexionBdd;
        $this->db = $instanceConnexion->connect();
    }

    function findAllExemplairesByOeuvre($noOeuvre){
        $requete ="SELECT EX1.id as noExemplaire, EX1.etat, EX1.date_achat, EX1.prix, COUNT(EX1.oeuvre_id) AS nbExemplaire, COUNT(EX2.id) AS nombreDispo
        FROM OEUVRE AS OE
        LEFT JOIN EXEMPLAIRE AS EX1 ON OE.id = EX1.oeuvre_id
        LEFT JOIN EXEMPLAIRE AS EX2 ON EX1.id = EX2.id
            AND EX2.id NOT IN (SELECT EMPRUNT.exemplaire_id 
                FROM EMPRUNT 
                WHERE EMPRUNT.date_retour IS NULL)
        WHERE EX1.oeuvre_id = :noOeuvre        
        GROUP BY EX1.id;";
        $prep=$this->db->prepare($requete);
        $prep->bindParam(":noOeuvre",$noOeuvre,\PDO::PARAM_INT);
        $prep->execute();
        $result = $prep->fetchAll();
        return $result;
    }

    function findDetailsAllExemplairesByOeuvre($noOeuvre){
        $requete="SELECT OE.id, OE.titre, AU.nom as nomAuteur, OE.date_parution as dateParution, OE.photo, COUNT(EX1.oeuvre_id) AS nbExemplaire, COUNT(EX2.id) AS nombreDispo, COUNT(EX1.oeuvre_id)-COUNT(EX2.id) AS nbAbsent
        FROM OEUVRE AS OE
        INNER JOIN AUTEUR AS AU ON OE.auteur_id = AU.id
        LEFT JOIN EXEMPLAIRE AS EX1 ON OE.id = EX1.oeuvre_id
        LEFT JOIN EXEMPLAIRE AS EX2 ON EX1.id = EX2.id
            AND EX2.id NOT IN (SELECT EMPRUNT.exemplaire_id 
                FROM EMPRUNT 
                WHERE EMPRUNT.date_retour IS NULL)
        WHERE EX1.oeuvre_id = :noOeuvre;";
        $prep=$this->db->prepare($requete);
        $prep->bindParam(":noOeuvre", $noOeuvre,\PDO::PARAM_INT);
        $prep->execute();
        $result=$prep->fetchAll();
        return $result;
    }

    function findByIdOeuvreExemplaire($id){
        $requete ="SELECT oeuvre_id as noExemplaire, EXEMPLAIRE.id as idExemplaire, etat, date_achat 
        FROM EXEMPLAIRE 
        WHERE oeuvre_id = :id;";
        $prep=$this->db->prepare($requete);
        $prep->bindParam(":id", $id, \PDO::PARAM_INT);
        $prep->execute();
        $result = $prep->fetchAll();
        return $result;
    }

    function createAndPersistExemplaire($donnees){
        $requete=" INSERT INTO EXEMPLAIRE (id, etat, date_achat, prix, oeuvre_id) 
            VALUES (NULL,'${donnees['etat']}','${donnees['date_achat']}','${donnees['prix']}','${donnees['noOeuvre']}');";
        $nbRes = $this->db->exec($requete);
    }

    function removeByIdExemplaire($noExemplaire){
        $requete="DELETE FROM EXEMPLAIRE
        WHERE id =:noExemplaire LIMIT 1;";
        $prep=$this->db->prepare($requete);
        $prep->bindParam(':noExemplaire',$noExemplaire,\PDO::PARAM_INT);
        $Res=$prep->execute();
        return $Res;
    }

    function findOneById($noExemplaire){
        $requete ="SELECT id, etat, date_achat, prix, oeuvre_id
        FROM EXEMPLAIRE
        WHERE id=:noExemplaire";
        $prep=$this->db->prepare($requete);
        $prep->bindParam(':noExemplaire',$noExemplaire,\PDO::PARAM_INT);
        $prep->execute();
        $result = $prep->fetch();
        return $result;
    }


    function updateAndPersistExemplaire($id, $donnees){
        $requete="UPDATE EXEMPLAIRE SET etat=:etat, date_achat=:date_achat, prix=:prix
        WHERE id=:id;";
        $donnees['date_achat']=\DateTime::createFromFormat('d/m/Y', $donnees['date_achat'])->format('Y-m-d');
        $prep=$this->db->prepare($requete);
        $prep->bindParam(':id',$id,\PDO::PARAM_INT);
        $prep->bindParam(':etat',$donnees['etat'],\PDO::PARAM_STR_CHAR);
        $prep->bindParam(':date_achat',$donnees['date_achat'],\PDO::PARAM_STR_CHAR);
        $prep->bindParam(':prix',$donnees['prix'],\PDO::PARAM_INT);
        $Res=$prep->execute();
        return $Res;
    }

    function findIdOeuvreByIdExemplaire($noExemplaire){
        $requete ="SELECT oeuvre_id as idOeuvre
        FROM EXEMPLAIRE 
        WHERE id = :noExemplaire;";
        $prep=$this->db->prepare($requete);
        $prep->bindParam(":noExemplaire", $noExemplaire, \PDO::PARAM_INT);
        $prep->execute();
        $result = $prep->fetchAll();
        return $result;
    }
}
