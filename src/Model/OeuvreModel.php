<?php
namespace App\Model;

use App\Model\ConnexionBdd;
use PDO;

class OeuvreModel{

    private $db;

    public function __construct(){
        $instanceConnexion = new ConnexionBdd;
        $this->db = $instanceConnexion->connect();
    }

    function findAllOeuvres(){
        $requete ="
        SELECT AUTEUR.nom, OEUVRE.titre, OEUVRE.id, DATE_FORMAT(OEUVRE.date_parution, '%d-%m-%Y') as dateParution, OEUVRE.photo
        , COUNT(E1.id) AS nbExemplaire
        , COUNT(E2.id) AS nombreDispo
        FROM OEUVRE
        JOIN AUTEUR ON AUTEUR.id = OEUVRE.auteur_id
        LEFT JOIN EXEMPLAIRE E1 ON E1.oeuvre_id = OEUVRE.id
        LEFT JOIN EXEMPLAIRE E2 ON E2.id = E1.id
            AND E2.id NOT IN (SELECT EMPRUNT.exemplaire_id FROM EMPRUNT WHERE EMPRUNT.date_retour IS NULL)
        GROUP BY OEUVRE.id
        ORDER BY AUTEUR.nom ASC, OEUVRE.titre ASC;";
        $prep=$this->db->prepare($requete);
        $prep->execute();
        $results = $prep->fetchAll();
        return $results;
    }


    function findByIdAuteurOeuvre($id){
        $requete = "
        SELECT id AS noOeuvre, auteur_id AS idAuteur, titre, date_parution AS dateParution, photo 
        FROM oeuvre
        WHERE auteur_id = ?;";
        // alain pourquoi ? pas compris
        $prep = $this->db->prepare($requete);
        $prep->bindParam(1, $id, PDO::PARAM_INT);
        $prep->execute();
        $result = $prep->fetchAll();
        return $result;
    }


    function createAndPersistOeuvre($donnees){
        $requete ="INSERT INTO OEUVRE (id, titre, date_parution, photo, auteur_id) VALUES
            (NULL, '${donnees['titre']}', '${donnees['dateParution_us']}', '${donnees['photo']}', '${donnees['idAuteur']}');";
        $nbRes = $this->db->exec($requete);
    }


    function removeByIdOeuvre($id){
        $requete="
        DELETE FROM OEUVRE 
        WHERE id=:id LIMIT 1;";
        $prep = $this->db->prepare($requete);
        $prep->bindParam(':id', $id, \PDO::PARAM_INT);
        $Res = $prep->execute();
        return $Res;
    }

    function findOneByIdOeuvre($id){
        $requete = "
        SELECT id, titre, date_parution as dateParution, photo, auteur_id
        FROM OEUVRE
        WHERE id=:id;";
        $prep = $this->db->prepare($requete);
        $prep->bindParam(':id', $id, \PDO::PARAM_INT);
        $prep->execute();
        $result = $prep->fetch();
        return $result;
    }

    function updateAndPersistOeuvre($id, $donnees){
        $requete= "
        UPDATE OEUVRE SET
        titre=:titre,
        photo=:photo,
        date_parution=:dateParution,
        auteur_id = :idAuteur
        WHERE id=:id";
        $prep = $this->db->prepare($requete);
        $prep->bindParam(':id', $id, \PDO::PARAM_INT);
        $prep->bindParam(':titre', $donnees['titre'], \PDO::PARAM_STR_CHAR);
        $prep->bindParam(':photo', $donnees['photo'], \PDO::PARAM_STR_CHAR);
        $prep->bindParam(':idAuteur', $donnees['idAuteur'], \PDO::PARAM_INT);
        $prep->bindParam(':dateParution', $donnees['dateParution_us'], \PDO::PARAM_STR_CHAR);
        $result = $prep->execute();
        return $result;
    }

}
