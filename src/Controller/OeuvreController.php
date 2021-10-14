<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Model\AuteurModel;
use App\Model\OeuvreModel;
use App\Model\ExemplaireModel;
use function Sodium\add;


class OeuvreController  extends AbstractController
{
    private $instanceModelOeuvre;
    private $instanceModelExemplaire;
    private $instanceModelAuteur;

    public function __construct(){
        $this->instanceModelAuteur = new AuteurModel();
        $this->instanceModelOeuvre = new OeuvreModel();
        $this->instanceModelExemplaire = new ExemplaireModel();
    }


    /**
     * @Route("/oeuvre", name="oeuvre_index")
     */
    public function index()
    {
        return $this->render('layout.html.twig', [
            'controller_name' => 'OeuvreController',
            ]);
    }


    /**
     * @Route("/oeuvre/afficherOeuvres", name="oeuvre_afficherOeuvres")
     */
    public function afficherOeuvres()
    {
        $oeuvres=$this->instanceModelOeuvre->findAllOeuvres();
        return $this->render('oeuvre/showOeuvre.html.twig', ['oeuvres' => $oeuvres]);
    }


    /**
     * @Route("/oeuvre/creerOeuvre", name="oeuvre_creerOeuvre")
     */
    public function creerOeuvre()
    {
        $auteurs = $this->instanceModelAuteur->findAllAuteurs();
        return $this->render('oeuvre/addOeuvre.html.twig', ['donneesAuteur' => $auteurs]);
    }


    /**
     * @Route("/oeuvre/validFormCreerOeuvre", name="oeuvre_validFormCreerOeuvre")
     */
    public function validFormCreerOeuvre()
    {
        $donnees['titre']=$_POST['titre'];
        $donnees['dateParution']=htmlentities($_POST['dateParution']);
        $donnees['photo']=htmlentities($_POST['photo']);
        $donnees['idAuteur'] = htmlentities($_POST['idAuteur']);
        $erreurs=$this->validatorOeuvre($donnees);
        if (empty($erreurs)) {
            $donnees['titre'] = addslashes($donnees['titre']);
            $donnees['dateParution_us']=\DateTime::createFromFormat('d/m/Y', $donnees['dateParution']) ->format('Y-m-d');
            $this->instanceModelOeuvre->createAndPersistOeuvre($donnees);
            return $this->redirectToRoute("oeuvre_afficherOeuvres");
        }
        $auteurs = $this->instanceModelAuteur->findAllAuteurs();
        return $this->render('oeuvre/addOeuvre.html.twig', ['erreurs' => $erreurs, 'donnees' => $donnees, 'donneesAuteur' => $auteurs]);
    }

    /**
     * @Route("/oeuvre/supprimerOeuvre/{id}", name="oeuvre_supprimerOeuvre")
     */
    public function supprimerOeuvre($id='')
    {
       dump($id);
       $donnees = $this->instanceModelExemplaire->findByIdOeuvreExemplaire($id);
       $nombre = count($donnees);
       dump($nombre);
       dump($donnees);
       if (empty($donnees)) {
           $this->instanceModelOeuvre->removeByIdOeuvre($id);
           return $this->redirectToRoute('oeuvre_afficherOeuvres');
       }else
           return $this->render('oeuvre/ErrorDeleteOeuvre.html.twig', ['nombre' => $nombre]);
    }


    /**
     * @Route("/oeuvre/modifierOeuvre/{id}", name="oeuvre_modifierOeuvre")
     */
    public function modifierOeuvre($id='')
    {
        $donnees = $this->instanceModelOeuvre->findOneByIdOeuvre($id);
        $donnees['idAuteur'] = htmlentities($donnees['auteur_id']);
        $donnees['dateParution'] = \DateTime::createFromFormat('Y-m-d', $donnees['dateParution'])->format('d/m/Y');
        $auteurs = $this->instanceModelAuteur->findAllAuteurs();

        return $this->render('oeuvre/editOeuvre.html.twig', ['donnees' => $donnees, 'donneesAuteur' => $auteurs]);
    }


    /**
     * @Route("/oeuvre/validFormModifierOeuvre", name="oeuvre_validFormModifierOeuvre")
     */
    public function validFormModifierOeuvre()
    {
        $donnees['titre'] = $_POST['titre'];
        $donnees['dateParution'] = htmlentities($_POST['dateParution']);
        $donnees['photo'] = htmlentities($_POST['photo']);
        $donnees['idAuteur'] = htmlentities($_POST['idAuteur']);
        $donnees['id'] = $_POST['id'];
        $erreurs =$this->validatorOeuvre($donnees);
        if (empty($erreurs)) {
            $donnees['titre'] =  addslashes($donnees['titre']);
            $donnees['dateParution_us'] = \DateTime::createFromFormat('d/m/Y', $donnees['dateParution'])->format('Y-m-d');
            $this->instanceModelOeuvre->updateAndPersistOeuvre($donnees['id'], $donnees);
            return $this->redirectToRoute('oeuvre_afficherOeuvres');
        }
        $auteurs = $this->instanceModelAuteur->findAllAuteurs();
        return $this->render('oeuvre/editOeuvre.html.twig', ['erreurs' => $erreurs, 'donnees' => $donnees, 'donneesAuteur' => $auteurs]);
    }


    public function validatorOeuvre($donnees)
    {
        $erreurs=array();
        if (! preg_match("/^[A-Za-z]{2,}/", $donnees['titre']))
            $erreurs['titre'] = 'titre composé de 2 lettres minimum';
        if (! is_numeric($donnees['idAuteur']))
            $erreurs['idAuteur'] = 'saisir une valeur';
        $dateConvert = \DateTime::createFromFormat('d/m/Y', $donnees['dateParution']);
        if ($dateConvert == NULL)
            $erreurs['dateParution'] = 'La date doit etre au format JJ/MM/AAAA';
        else{
            if ($dateConvert->format('d/m/Y') !== $donnees['dateParution'])
                $erreurs['dateParution'] = 'La date n\'est pas valide (forma jj/mm/aaaa';
        }

        if ($donnees['photo'] != "")
        {
            $file = './assets/images/'.$donnees['photo'];
            if (! file_exists($file))
                $erreurs['photo'] = 'la photo qui n\'existe pas danns le dossier assets/images/';
        }
        return $erreurs;
    }
}