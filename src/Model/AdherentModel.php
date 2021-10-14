<?php
namespace App\Model;

use App\Model\ConnexionBdd;

class AdherentModel{

    private $db;

    public function __construct(){
        $instanceConnexion = new ConnexionBdd;
        $this->db = $instanceConnexion->connect();
    }

    function findAllAdherents(){
        $requete="
        SELECT ad.nom, ad.adresse, ad.date_paiement as datePaiement, ad.id, count(empr.adherent_id) as nbrEmprunt,
        IF(CURRENT_DATE()>DATE_ADD(date_paiement, INTERVAL 1 YEAR ),1,0) as retard,
        IF(CURRENT_DATE()>DATE_ADD(date_paiement, INTERVAL 11 MONTH ),1,0) as retardProche,
        DATE_ADD(date_paiement, INTERVAL 1 YEAR ) as datePaiementFutur
        FROM ADHERENT ad
        LEFT JOIN EMPRUNT empr ON empr.adherent_id=ad.id
        AND empr.date_retour is null;
        GROUP BY ad.id
        order by ad.nom;";
        //'0000-00-00' au lieu de is null
        $prep=$this->db->prepare($requete);
        $prep->execute();
        $results = $prep->fetchAll();
        return $results;
    }

    function findAllDropdownAdherents(){
        //
    }

    function createAndPersistAdherent($donnees){
        $requete="INSERT INTO ADHERENT (id,nom,adresse,date_paiement) VALUES 
                    (NULL,'${donnees['nom']}','${donnees['adresse']}','${donnees['datePaiement_us']}');";
        $nbRes=$this->db->exec($requete);
    }


    function removeByIdAdherent($id){
        $requete="
        DELETE FROM ADHERENT WHERE id=:id LIMIT 1;";
        $prep=$this->db->prepare($requete);
        $prep->bindParam(':id', $id, \PDO::PARAM_INT);
        $Res=$prep->execute();
        return $Res;
    }

    function findOneByIdAdherent($id){
        $requete="SELECT id,nom,adresse,date_paiement as datePaiement
        FROM ADHERENT
        WHERE id=:id;";
        $prep=$this->db->prepare($requete);
        $prep->bindParam(':id',$id,\PDO::PARAM_INT);
        $prep->execute();
        $result=$prep->fetch();
        return $result;
    }


    function updateAndPersistAdherent($id, $donnees){
        $requete="UPDATE ADHERENT SET
        nom=:nom,
        adresse=:adresse,
        date_paiement=:date_paiement
        WHERE id=:id";
        //dd($donnees);
        $prep=$this->db->prepare($requete);
        $prep->bindParam(':id',$id,\PDO::PARAM_INT);
        $prep->bindParam(':nom',$donnees['nom'],\PDO::PARAM_STR_CHAR);
        $prep->bindParam(':adresse',$donnees['adresse'],\PDO::PARAM_STR_CHAR);
        $prep->bindParam(':date_paiement',$donnees['datePaiement_us']);
        $Res=$prep->execute();
        return $Res;
    }
}

