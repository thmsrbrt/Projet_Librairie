<?php

namespace App\Controller;


use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Model\AdherentModel;
use App\Model\EmpruntModel;


class AdherentController extends AbstractController
{

    private $instanceModelEmprunt;
    private $instanceModelAdherent;

    public function __construct(){
        $this->instanceModelAdherent = new AdherentModel();
        $this->instanceModelEmprunt = new EmpruntModel();
    }


    /**
     * @Route("/adherent", name="adherent_index")
     */
    public function index()
    {
        return $this->render('layout.html.twig', [
            'controller_name' => 'AdherentController',
        ]);
    }


    /**
     * @Route("/adherent/afficherAdherents", name="adherent_afficherAdherents")
     */
    public function afficherAdherents()
    {
        $adherents=$this->instanceModelAdherent->findAllAdherents();
        #dd($adherents);
        return $this->render('adherent/showAdherents.html.twig',['adherents' => $adherents]);
    }

    /**
     * @Route("/adherent/creerAdherent", name="adherent_creerAdherent")
     */
    public function creerAdherent()
    {
        $aujourdhui = new \DateTime();
        $donnees['datePaiement']=$aujourdhui->format('d/m/Y');
        return $this->render('adherent/addAdherent.html.twig',['donnees' => $donnees]);
    }

    /**
     * @Route("/adherent/validFormCreerAdherent", name="adherent_validFormCreerAdherent")
     */
    public function validFormCreerAdherent()
    {
        $donnees['nom']=$_POST['nom'];
        $donnees['adresse']=htmlentities($_POST['adresse']);
        $donnees['datePaiement']=htmlentities($_POST['datePaiement']);
        // Contrôles des données
        $erreurs=$this->validatorAdherent($donnees);
        if (empty($erreurs)){
            $donnees['nom'] = addslashes($donnees['nom']);
            $donnees['datePaiement_us']=\DateTime::createFromFormat('d/m/Y', $donnees['datePaiement']) -> format('Y-m-d');
            $this->instanceModelAdherent->createAndPersistAdherent($donnees);
            return $this->redirectToRoute("adherent_afficherAdherents");
        }
        return $this->render('adherent/addAdherent.html.twig',['erreurs' => $erreurs, 'donnees' => $donnees]);
    }

    /**
     * @Route("/adherent/supprimerAdherent/{id}", name="adherent_supprimerAdherent")
     */
    public function supprimerAdherent($id='')
    {
        dump($id);
        $donnees = $this->instanceModelEmprunt->findByIdAdherentEmprunt($id);
        $nombre = count($donnees);
        dump($nombre);
        dump($donnees);
        if (empty($donnees)){
            $this->instanceModelAdherent->removeByIdAdherent($id);
            return $this->redirectToRoute('adherent_afficherAdherents');
        }
        else return $this->render('adherent/ErrorDeleteAdherent.html.twig',['nombre' => $nombre]);

    }

    /**
     * @Route("/adherent/modifierAdherent/{id}", name="adherent_modifierAdherent")
     */
    public function modifierAdherent($id='')
    {
        $donnees=$this->instanceModelAdherent->findOneByIdAdherent($id);
        $donnees['datePaiement'] = \DateTime::createFromFormat('Y-m-d', $donnees['datePaiement'])->format('d/m/Y');
        return $this->render('adherent/editAdherent.html.twig',['donnees' => $donnees]);
    }

    /**
     * @Route("/adherent/validFormModifierAdherent", name="adherent_validFormModifierAdherent")
     */
    public function validFormModifierAdherent()
    {
        $donnees['nom']=$_POST['nom'];
        $donnees['adresse']=htmlentities($_POST['adresse']);
        $donnees['datePaiement']=htmlentities($_POST['datePaiement']);
        $donnees['id']=$_POST['id'];
        // Contrôles des données
        $erreurs=$this->validatorAdherent($donnees);
        if (empty($erreurs)){
            $donnees['nom'] = addslashes($donnees['nom']);
            $donnees['datePaiement_us']=\DateTime::createFromFormat('d/m/Y', $donnees['datePaiement']) -> format('Y-m-d');
            $this->instanceModelAdherent->updateAndPersistAdherent($donnees['id'],$donnees);
            return $this->redirectToRoute("adherent_afficherAdherents");
        }
        return $this->render('adherent/editAdherent.html.twig',['erreurs' => $erreurs, 'donnees' => $donnees]);
    }


    public function validatorAdherent($donnees)
    {
        $erreurs=array();

        if (! preg_match("/[A-Za-z]{2,}/",$donnees['nom']))
            $erreurs['nom'] = 'nom composé de 2 lettres minimum';
        if (! preg_match("/[A-Za-z]{2,}/",$donnees['adresse']))
            $erreurs['adresse'] = 'adresse composée de 2 lettres minimum';

        $dateConvert=\DateTime::createFromFormat('d/m/Y',$donnees['datePaiement']);
        if ($dateConvert==NULL)
            $erreurs['datePaiement'] = 'la date doit être au format JJ/MM/AAAA';
        else{
            if ($dateConvert->format('d/m/Y') !== $donnees['datePaiement'])
                $erreurs['datePaiement'] = 'la date n\'est pas valide (format jj/mm/aaaa)';
        }
        return $erreurs;
    }


    // bonus
    /**
     * @Route("/adherent/confirmerSuppr/{id}", name="adherent_confirmerSuppr")
     */
    public function confirmerSuppr($id='')
    {
    }
}
