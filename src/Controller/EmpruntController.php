<?php

namespace App\Controller;


use App\Model\EmpruntModel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Model\AuteurModel;
use App\Model\OeuvreModel;
use App\Model\AdherentModel;
use App\Model\ExemplaireModel;


class EmpruntController  extends AbstractController
{
    private $instanceModelAdherent;
    private $instanceModelExemplaire;
    private $instanceModelEmprunt;


    public function __construct(){
        $this->instanceModelAdherent = new AdherentModel();
        $this->instanceModelExemplaire = new ExemplaireModel();
        $this->instanceModelEmprunt = new EmpruntModel();
    }

    /**
     * @Route("/emprunt", name="emprunt_index")
     */
    public function index()
    {
        return $this->render('layout.html.twig', [
            'controller_name' => 'EmpruntController',
        ]);
    }

    // addEmpunts

    /**
     * @Route("/emprunt/selectAdherentEmprunts", name="emprunt_selectAdherentEmprunts")
     */
    public function selectAdherentEmprunts()
    {
        return $this->render('layout.html.twig',['controller_name' => 'emprunt , selectAdherentEmprunts :  à complèter']);
    }



    /**
     * @Route("/emprunt/addEmprunts", name="emprunt_addEmprunts")
     */
    public function addEmprunts()
    {

    }

    // deleteAllEmpunts
    /**
     * @Route("/emprunt/deleteAllEmprunts", name="emprunt_deleteAllEmprunts")
     */
    public function deleteAllEmprunts()
    {
        return $this->render('layout.html.twig',['controller_name' => 'emprunt , deleteAllEmprunts : à complèter']);
    }

    /**
     * @Route("/emprunt/validFormAddDeleteAllEmprunts/{id}", name="emprunt_validFormAddDeleteAllEmprunts")
     */
    public function validFormAddDeleteAllEmprunts($id='')
    {

  
    }

    //returnEmprunts
    /**
     * @Route("/emprunt/returnEmprunts/{id}", name="emprunt_returnEmprunts")
     */
    public function returnEmprunts($id='')
    {
   
    }

    /**
     * @Route("/emprunt/bilanEmprunts", name="emprunt_bilanEmprunts")
     */
    public function bilanEmprunts()
    {
        return $this->render('layout.html.twig',['controller_name' => 'emprunt , bilanEmprunts : à complèter']);
    }


    public function validatorEmprunt($donnees)
    {
        $erreurs=array();
      
        return $erreurs;
    }

    public function validatorRetour($donnees)
    {
        $erreurs=array();
    
        return $erreurs;
    }

}




