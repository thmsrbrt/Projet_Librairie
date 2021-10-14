<?php

namespace App\Controller;

use App\Entity\Auteur;
use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Model\AuteurModel;
use App\Model\OeuvreModel;


class Auteur2Controller extends AbstractController
{

    private $instanceModelOeuvre;
    private $instanceModelAuteur;

    public function __construct(){
        $this->instanceModelAuteur = new AuteurModel();
        $this->instanceModelOeuvre = new OeuvreModel();
    }

    /**
     * @Route("/auteur2", name="auteur2_index")
     */
    public function index()
    {

    }


    /**
     * @Route("/auteur2/afficherAuteurs", name="auteur2_afficherAuteurs")
     */
    public function afficherAuteurs()
    {
        $auteurs=$this->getDoctrine()->getRepository(Auteur::class)->findAllAuteurs();
        // dd($auteurs);
        return $this->render('auteur2/showAuteurs.html.twig',['auteurs' => $auteurs]);
    }

    /**
     * @Route("/auteur2/creerAuteur", name="auteur2_creerAuteur")
     */
    public function creerAuteur()
    {
        return $this->render('auteur2/addAuteur.html.twig');
    }

    /**
     * @Route("/auteur2/validFormCreerAuteur", name="auteur2_validFormCreerAuteur")
     */

    public function validFormCreerAuteur(): Response
    {
        $entityManager=$this->getDoctrine()->getManager();

        $donnees['nom'] = $_POST['nom'];
        $donnees['prenom'] = htmlentities($_POST['prenom']);

        $auteur = new Auteur();
        $auteur->setNom($donnees['nom']);
        $auteur->setPrenom($donnees['prenom']);
        $entityManager->persist($auteur);
        $entityManager->flush();
        $erreurs=$this->validatorAuteur($donnees);
        if (empty($erreurs)) {
            return new Response('auteur2_afficherAuteurs'. $auteur->getNom());
        }
        return Response('auteur2/addAuteur.html.twig', ['erreurs' => $erreurs, 'donnees' => $donnees]);
    }

    /**
     * @Route("/auteur2/supprimerAuteur/{id}", name="auteur2_supprimerAuteur")
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
            return $this->redirectToRoute('auteur2_afficherAuteurs');
        }else
            return $this->render('auteur2/ErrorDeleteAuteur.html.twig', ['nombre' => $nombre]);
    }

    /**
     * @Route("/auteur2/modifierAuteur/{id}", name="auteur2_modifierAuteur")
     */

    public function modifierAuteur($id='')
    {
        $auteur = $this->instanceModelAuteur->findOneByIdAuteur($id);
        dump($auteur);
        return $this->render('auteur2/editAuteur.html.twig', ['donnees' => $auteur]);
    }

    /**
     * @Route("/auteur2/validFormModifierAuteur", name="auteur2_validFormModifierAuteur")
     */

    public function validFormModifierAuteur()
    {
        $donnees['nom'] = $_POST['nom'];
        $donnees['prenom'] = $_POST['prenom'];
        $donnees['id'] = $_POST['id'];
        $erreurs = $this->validatorAuteur($donnees);
        if (empty($erreurs)) {
            $this->instanceModelAuteur->updateAndPersistAuteur($donnees['id'], $donnees);
            return $this->redirectToRoute('auteur2_afficherAuteurs');
        }
        return $this->render('auteur2/editAuteur.html.twig', ['erreurs' => $erreurs, 'donnees' => $donnees]);
    }


    public function validatorAuteur($donnees)
    {
        $erreurs=array();
        if (! preg_match("/^[A-Za-z ]{2,}/", $donnees['nom']))
            $erreurs['nom'] = 'nom composé de 2 lettres minimum';
        return $erreurs;
    }
}
