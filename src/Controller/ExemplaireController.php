<?php
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Model\EmpruntModel;
use App\Model\OeuvreModel;
use App\Model\ExemplaireModel;


class ExemplaireController extends AbstractController
{
    private $instanceModelOeuvre;
    private $instanceModelExemplaire;
    private $instanceModelEmprunt;
    private $twig;


    public function __construct(){
        $this->instanceModelEmprunt = new EmpruntModel();
        $this->instanceModelOeuvre = new OeuvreModel();
        $this->instanceModelExemplaire = new ExemplaireModel();
    }

    /**
     * @Route("/exemplaire", name="exemplaire_index")
     */
    public function index()
    {
        echo $this->twig->render('layout.html.twig');
    }

    /**
     * @Route("/exemplaire/afficherExemplaires", name="exemplaire_afficherExemplaires")
     */
    public function afficherExemplaires()
    {
        $noOeuvre = $_GET['noOeuvre'];
        $oeuvres = $this->instanceModelExemplaire->findDetailsAllExemplairesByOeuvre($noOeuvre);
        $exemplaires = $this->instanceModelExemplaire->findAllExemplairesByOeuvre($noOeuvre);
        //dd($oeuvres, $exemplaires);
        return $this->render('exemplaire/showExemplaires.html.twig', ['oeuvres' => $oeuvres, 'exemplaires' => $exemplaires]);
    }

    /**
     * @Route("/exemplaire/creerExemplaire/{noOeuvre}", name="exemplaire_creerExemplaire")
     */
    public function creerExemplaire($noOeuvre)
    {
        $aujourdhui = new \DateTime();
        $exemplaires = $this->instanceModelExemplaire->findAllExemplairesByOeuvre($noOeuvre);
        $oeuvres = $this->instanceModelExemplaire->findDetailsAllExemplairesByOeuvre($noOeuvre);
        $exemplaires['date_achat']=$aujourdhui->format('d/m/Y');
        return $this->render('exemplaire/addExemplaire.html.twig', ['oeuvres' => $oeuvres, 'exemplaires' => $exemplaires]);
    }


    /**
     * @Route("/exemplaire/validFormCreerExemplaire", name="exemplaire_validFormCreerExemplaire")
     */
    public function validFormCreerExemplaire()
    {
        $exemplaires['etat'] = htmlentities($_POST['etat']);
        $exemplaires['noOeuvre']= htmlentities($_POST['idOeuvre']);
        $exemplaires['prix']=$_POST['prix'];
        $exemplaires['date_achat']=$_POST['date_achat'];
        // ## contrôles des données
        $erreurs=$this->validatorExemplaire($exemplaires);
        //dd($donnees);
        if (empty($erreurs)) {
            $exemplaires['date_achat']=\DateTime::createFromFormat('d/m/Y',$exemplaires['date_achat'])->format('Y-m-d');
            //dd($donnees);
            $this->instanceModelExemplaire->createAndPersistExemplaire($exemplaires);
            return $this->redirectToRoute('exemplaire_afficherExemplaires', ['noOeuvre' => $exemplaires['noOeuvre']]);
        }
        $oeuvres=$this->instanceModelExemplaire->findDetailsAllExemplairesByOeuvre($exemplaires['noOeuvre']);
        return $this->render('exemplaire/addExemplaire.html.twig',['erreurs' => $erreurs, 'oeuvres' => $oeuvres, 'exemplaires' => $exemplaires]);
    }

    /**
     * @Route("/exemplaire/supprimerExemplaire/{noExemplaire}", name="exemplaire_supprimerExemplaire")
     */
    public function supprimerExemplaire($noExemplaire='')
    {
        //dump($noExemplaire);
        $donnees = $this->instanceModelEmprunt->findByIdExemplaireEmprunt($noExemplaire);
        $noOeuvre = $this->instanceModelExemplaire->findIdOeuvreByIdExemplaire($noExemplaire);
        //dd($noOeuvre);
        dd($donnees);
        $nombre = count($donnees);
        dump($nombre);
        dump($donnees);
        if (!empty($donnees)){
            $this->instanceModelExemplaire->removeByIdExemplaire($noExemplaire);
            return $this->redirectToRoute('exemplaire_afficherExemplaires',['noOeuvre'=>$noOeuvre['0']['idOeuvre']]);
        }
        return $this->render('exemplaire/ErrorDeleteExemplaire.html.twig',['nombre'=>$nombre, 'noOeuvre'=>$noOeuvre['0']['idOeuvre']]);
    }


    /**
     * @Route("/exemplaire/modifierExemplaire/{noExemplaire}", name="exemplaire_modifierExemplaire")
     */
    public function modifierExemplaire($noExemplaire='')
    {
        $exemplaire=$this->instanceModelExemplaire->findOneById($noExemplaire);
        $exemplaire['date_achat']=\DateTime::createFromFormat('Y-m-d', $exemplaire['date_achat'])->format('d/m/Y');
        $oeuvres = $this->instanceModelExemplaire->findDetailsAllExemplairesByOeuvre($exemplaire['oeuvre_id']);
        //dd($oeuvres, $exemplaire);
        //dd($donneesAuteur);
        return $this->render('exemplaire/editExemplaire.html.twig',['exemplaire' => $exemplaire, 'oeuvres'=> $oeuvres]);
    }

    /**
     * @Route("/exemplaire/validFormModifierExemplaire", name="exemplaire_validFormModifierExemplaire")
     */
    public function validFormModifierExemplaire()
    {
        $exemplaire['id']= $_POST['id'];
        $exemplaire['etat']= htmlentities($_POST['etat']);
        $exemplaire['prix']=htmlentities($_POST['prix']);
        $exemplaire['date_achat']=htmlentities($_POST['date_achat']);
        $exemplaire['oeuvre_id']=htmlentities($_POST['oeuvre_id']);
        $oeuvres = $this->instanceModelExemplaire->findDetailsAllExemplairesByOeuvre($exemplaire['oeuvre_id']);
        $erreurs=$this->validatorExemplaire($exemplaire);
        if(empty($erreurs)){
            $this->instanceModelExemplaire->updateAndPersistExemplaire($exemplaire['id'], $exemplaire);
            return $this->redirectToRoute('exemplaire_afficherExemplaires', ['noOeuvre' => $exemplaire['oeuvre_id']]);
        }
        return $this->render('exemplaire/editExemplaire.html.twig',['erreurs'=>$erreurs, 'oeuvres'=>$oeuvres, 'exemplaire'=>$exemplaire]);
    }


    public function validatorExemplaire($donnees)
    {
        $erreurs=array();

        if (! preg_match("/^[A-Za-z ]{2,}/", $donnees['etat']))
            $erreurs['etat']='etat composé de 2 lettres minimum';
        if (! is_numeric($donnees['prix']))
            $erreurs['prix'] = 'le format doit être dddd,dd';

        $dateConvert=\DateTime::createFromFormat('d/m/Y', $donnees['date_achat']);
        if ($dateConvert==NULL)
            $erreurs['date_achat']='la date doit être au format JJ/MM/AAAA';
        else{
            if ($dateConvert->format('d/m/Y') !== $donnees['date_achat'])
                $erreurs['date_achat']='la date n\'est pas valide (format jj/mm/aaaa)';
        }

        return $erreurs;
    }

}





