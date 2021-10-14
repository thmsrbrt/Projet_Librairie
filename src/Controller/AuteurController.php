<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Model\AuteurModel;
use App\Model\OeuvreModel;


class AuteurController extends AbstractController
{

    private $instanceModelOeuvre;
    private $instanceModelAuteur;

    public function __construct(){
        $this->instanceModelAuteur = new AuteurModel();
        $this->instanceModelOeuvre = new OeuvreModel();
    }

    /**
     * @Route("/auteur", name="auteur_index")
     */
    public function index()
    {

    }


    /**
     * @Route("/auteur/afficherAuteurs", name="auteur_afficherAuteurs")
     */
    public function afficherAuteurs()
    {
        $auteurs = $this->instanceModelAuteur->findAllAuteurs();
        // dd($auteurs);
        return $this->render('auteur/showAuteurs.html.twig', ['auteurs' => $auteurs ]);
    }

    /**
     * @Route("/auteur/creerAuteur", name="auteur_creerAuteur")
     */
    public function creerAuteur()
    {
        return $this->render('auteur/addAuteur.html.twig');
    }

    /**
     * @Route("/auteur/validFormCreerAuteur", name="auteur_validFormCreerAuteur")
     */

    public function validFormCreerAuteur()
    {
        $donnees['nom'] = $_POST['nom'];
        $donnees['prenom'] =htmlentities($_POST['prenom']);
        # control des données
        $erreurs=$this->validatorAuteur($donnees);
        if (empty($erreurs)) {
            $this->instanceModelAuteur->createAndPersistAuteur($donnees);
            // ##redirection
            return $this->redirectToRoute('auteur_afficherAuteurs');
        }
        return $this->render('auteur/addAuteur.html.twig', ['erreurs' => $erreurs, 'donnees' => $donnees]);
    }

    /**
     * @Route("/auteur/supprimerAuteur/{id}", name="auteur_supprimerAuteur")
     */

    public function supprimerAuteur($id='')
    {
        dump($id);
        $donnees = $this->instanceModelOeuvre->findByIdAuteurOeuvre($id);
        $nombre = count($donnees);
        dump($nombre);
        dump($donnees);
        if (empty($donnees)) {
            $this->instanceModelAuteur->removeByIdAuteur($id);
            return $this->redirectToRoute('auteur_afficherAuteurs');
        }else
            return $this->render('auteur/ErrorDeleteAuteur.html.twig', ['nombre' => $nombre]);
    }

    /**
     * @Route("/auteur/modifierAuteur/{id}", name="auteur_modifierAuteur")
     */

    public function modifierAuteur($id='')
    {
        $auteur = $this->instanceModelAuteur->findOneByIdAuteur($id);
        dump($auteur);
        return $this->render('auteur/editAuteur.html.twig', ['donnees' => $auteur]);
    }

    /**
     * @Route("/auteur/validFormModifierAuteur", name="auteur_validFormModifierAuteur")
     */

    public function validFormModifierAuteur()
    {
        $donnees['nom'] = $_POST['nom'];
        $donnees['prenom'] = $_POST['prenom'];
        $donnees['id'] = $_POST['id'];
        $erreurs = $this->validatorAuteur($donnees);
        if (empty($erreurs)) {
            $this->instanceModelAuteur->updateAndPersistAuteur($donnees['id'], $donnees);
            return $this->redirectToRoute('auteur_afficherAuteurs');
        }
        return $this->render('auteur/editAuteur.html.twig', ['erreurs' => $erreurs, 'donnees' => $donnees]);
    }


    public function validatorAuteur($donnees)
    {
        $erreurs=array();
        if (! preg_match("/^[A-Za-z ]{2,}/", $donnees['nom']))
            $erreurs['nom'] = 'nom composé de 2 lettres minimum';
        return $erreurs;
    }
}
