<?php
namespace App\Model;

use App\Model\ConnexionBdd;

class EmpruntModel{

    private $db;

    public function __construct(){
        $instanceConnexion = new ConnexionBdd;
        $this->db = $instanceConnexion->connect();
    }


    //EmpruntModel
    function createAndPersistEmprunt($donnees){
        //
    }


    function updateAndPersistEmprunt($donnees){
        //
    }

    // exemplaires des oeuvres disponibles

    function findExemplaireOeuvreDispo(){
        //
    }


    function removeByIdEmprunt($donnees){
        //
    }


    function findAdherentEmprunt($idAdherent=""){
        //
    }

   function findByIdAdherentEmprunt($idAdherent){
        $requete="
            SELECT adherent_id AS noEmprunt 
            FROM EMPRUNT 
            WHERE adherent_id =:id;";
        $prep=$this->db->prepare($requete);
        $prep->bindParam( ':id' ,$idAdherent, \PDO::PARAM_INT);
        $prep->execute();
        $result = $prep->fetchAll();
        return $result;
    }


    function findByIdExemplaireEmprunt($noExemplaire){
    
    }

    // nombre d'exemplaires en retard pour un adhérent
    function findNbExempairesRetardAdherent($idAdherent){

    }

    // exemplaires des oeuvres disponibles
    function findExemplairesArendre($idAdherent){

    }


    ////////// pour emprunter un livre


    // liste des adhérents ayant le droit d'emprunter un livre (pour la liste déroulante des adhérents lors d'un emprunt
    function findEmpruntDropdownAdherents(){

    }

    // liste des adhérents ayant le droit d'emprunter un livre (pour la liste déroulante des adhérents lors d'un emprunt
    function findEmpruntsByOneAdherent($idAdherent){

    }

    // liste des adhérents ayant le droit d'emprunter un livre (pour la liste déroulante des adhérents lors d'un emprunt
    function findEmpruntReturnDropdownAdherents(){

    }

    // bilan
    function findEmpruntsBilan(){

    }

}

