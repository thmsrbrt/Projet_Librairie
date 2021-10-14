<?php

namespace App\DataFixtures;

use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Auteur;
use App\Entity\Adherent;
use App\Entity\Oeuvre;
use App\Entity\Emprunt;
use App\Entity\Exemplaire;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $manager->flush();
        echo "chargement des fixtures pour l'entité Auteur \n***\n\n";
        $this->load_auteurs($manager);
        $this->load_adherents($manager);
        $this->load_oeuvres($manager);
        $this->load_exemplaires($manager);
        $this->load_umprunt($manager);

    }

    public function load_auteurs($manager)
    {
        $tab_auteurs=[
            ["id" => 1, "nom" => "Christie" , "prenom" => "Agatha"],
            ["id" => 2, "nom" => "Chateaubriand" , "prenom" => "François-René"],
            ["id" => 3, "nom" => "Flaubert" , "prenom" => "Gustave"],
            ["id" => 4, "nom" => "Prévert" , "prenom" => "Jacques"],
            ["id" => 5, "nom" => "De La Fontaine" , "prenom" => "Jean"],
            ["id" => 6, "nom" => "Daudet" , "prenom" => "Alphonse"],
            ["id" => 7, "nom" => "Hugo" , "prenom" => "Victor"],
            ["id" => 8, "nom" => "Kessel" , "prenom" => "Joseph"],
            ["id" => 9, "nom" => "Duras" , "prenom" => "Marguerite"],
            ["id" => 10, "nom" => "Proust" , "prenom" => "Marcel"],
            ["id" => 11, "nom" => "Zola" , "prenom" => "Émile"],
            ["id" => 12, "nom" => "Highsmith" , "prenom" => "Patricia"],
            ["id" => 13, "nom" => "Kipling" , "prenom" => "Rudyard"],
            ["id" => 14, "nom" => "Azimov" , "prenom" => "Isaac"],
            ["id" => 15, "nom" => "Baudelaire" , "prenom" => "Charles"],
            ["id" => 16, "nom" => "Moliere" , "prenom" => "Jean-Baptiste Poquelin"]
        ];
        foreach ($tab_auteurs as $auteur)
        {
            $new_auteur = new Auteur();
            $new_auteur->setNom($auteur['nom']);
            $new_auteur->setPrenom($auteur['prenom']);
            $new_auteur->setNationalite($auteur['nationalite']);
            $manager->persist($new_auteur);
            echo "nom : ".$new_auteur."\n";
        }
        $manager->flush();
    }

    public function load_adherents($manager)
    {
        $tab_adherents = [
            ['id' => 1, "nomAdherent" => "billot", "adresse" => "Montbeliard", "datePaiement" => "2020-11-03"],
            ['id' => 2, "nomAdherent" => "lauvernay", "adresse" => "sevenans", "datePaiement" => "2020-06-13"],
            ['id' => 3, "nomAdherent" => "axelrad", "adresse" => "sevenans", "datePaiement" => "2020-01-12"],
            ['id' => 4, "nomAdherent" => "bedez", "adresse" => "hericourt", "datePaiement" => "2020-04-17"],
            ['id' => 5, "nomAdherent" => "berger", "adresse" => "les glacis", "datePaiement" => "2013-11-03"],
            ['id' => 6, "nomAdherent" => "cambot", "adresse" => "sevenans", "datePaiement" => "2020-12-15"],
            ['id' => 7, "nomAdherent" => "bonilla", "adresse" => "sochaux", "datePaiement" => "2020-02-17"],
            ['id' => 8, "nomAdherent" => "asproitis", "adresse" => "grenoble", "datePaiement" => "2020-12-04"],
            ['id' => 9, "nomAdherent" => "pereira", "adresse" => "danjoutin", "datePaiement" => "2020-11-03"],
            ['id' => 10, "nomAdherent" => "dupont", "adresse" => "grenoble", "datePaiement" => "2020-03-14"],
            ['id' => 11, "nomAdherent" => "durant", "adresse" => "belfort", "datePaiement" => "2020-12-16"],
            ['id' => 12, "nomAdherent" => "piton", "adresse" => "belfort", "datePaiement" => "2020-11-03"]
        ];
        foreach ($tab_adherents as $adherent)
        {
            $new_adherent = new Adherent();
            $new_adherent->setNom($adherent['nomAdherent']);
            $new_adherent->setAdresse($adherent['adresse']);
            //strtotime('now') à remplacer par la chaîne de texte (cellule du tableau)
            $new_adherent->setDatePaiement(\DateTime::createFromFormat('Y-m-d', strtotime('datePaiement')));
            $new_adherent->setTaille($adherent['taille']);
            $manager->persit($new_adherent);
            echo "nom : ".$new_adherent."\n";
        }
        $manager->flush();
    }

    public function load_oeuvres($manager)
    {
        $tab_oeuvres=[
            [ "idOeuvre" => 1 , "titre" => "le retour de Poirot" , "dateParution" => "1960-02-12" , "idAuteur" => "1" , "nomAuteur" => "Christie" , 'photo' => "leRetourDePoirot.jpg" ],
            [ "idOeuvre" => 2 , "titre" => "Poirot quitte la scène" , "dateParution" => "1975-05-01" , "idAuteur" => "1" , "nomAuteur" => "Christie" , 'photo' => Null ],
            [ "idOeuvre" => 3 , "titre" => "dix brèves rencontres" , "dateParution" => "1982-10-01" , "idAuteur" => "1" , "nomAuteur" => "Christie" , 'photo' => "dixBrevesRencontres.jpg" ],
            [ "idOeuvre" => 4 , "titre" => "le miroir de la mort" , "dateParution" => "1961-01-01" , "idAuteur" => "1" , "nomAuteur" => "Christie" , 'photo' => "leMiroirDuMort.jpeg" ],
            [ "idOeuvre" => 5 , "titre" => "paroles" , "dateParution" => "1694-01-01" , "idAuteur" => "4" , "nomAuteur" => "Prévert", 'photo' => Null ],
            [ "idOeuvre" => 6 , "titre" => "une créature de rêve" , "dateParution" => "1992-02-01" , "idAuteur" => "12" , "nomAuteur" => "Highsmith", 'photo' => Null ],
            [ "idOeuvre" => 7 , "titre" => "mémoire d'outre-tombe" , "dateParution" => "1949-01-01" , "idAuteur" => "2" , "nomAuteur" => "Chateaubriand", 'photo' => Null ],
            [ "idOeuvre" => 8 , "titre" => "Madame de Bovary" , "dateParution" => "1956-12-15" , "idAuteur" => "3" , "nomAuteur" => "Flaubert", 'photo' => Null ],
            [ "idOeuvre" => 9 , "titre" => "un amour de swam" , "dateParution" => "2004-06-01" , "idAuteur" => "9" , "nomAuteur" => "Duras", 'photo' => "unAmourDeSwann.jpeg" ],
            [ "idOeuvre" => 10 , "titre" => "les femmes savantes" , "dateParution" => "1672-03-16" , "idAuteur" => "16" , "nomAuteur" => "Moliere", 'photo' => Null ],
            [ "idOeuvre" => 11 , "titre" => "le misanthrope" , "dateParution" => "1666-01-01" , "idAuteur" => "16" , "nomAuteur" => "Moliere", 'photo' => Null ],
            [ "idOeuvre" => 12 , "titre" => "Les fleurs du mal" , "dateParution" => "1957-06-25" , "idAuteur" => "15" , "nomAuteur" => "Baudelaire", 'photo' => "lesFleursDuMal.jpg" ],
            [ "idOeuvre" => 13 , "titre" => "petits poèmes en prose" , "dateParution" => "1969-01-01" , "idAuteur" => "15" , "nomAuteur" => "Baudelaire", 'photo' => Null ],
            [ "idOeuvre" => 14 , "titre" => "les mondes perdus" , "dateParution" => "1980-05-06" , "idAuteur" => "14" , "nomAuteur" => "Azimov", 'photo' => "lesMondesPerdus.jpg" ],
            [ "idOeuvre" => 15 , "titre" => "La guerre des mondes" , "dateParution" => "1970-03-15" , "idAuteur" => "14" , "nomAuteur" => "Azimov", 'photo' => Null ],
            [ "idOeuvre" => 16 , "titre" => "spectacles" , "dateParution" => "1948-05-12" , "idAuteur" => "4" , "nomAuteur" => "Prévert", 'photo' => Null ],
            [ "idOeuvre" => 17 , "titre" => "Les fables" , "dateParution" => "1694-01-01" , "idAuteur" => "5" , "nomAuteur" => "De La Fontaine", 'photo' => Null ],
            [ "idOeuvre" => 18 , "titre" => "Le triomphe de l'amour" , "dateParution" => "1980-05-06" , "idAuteur" => "5" , "nomAuteur" => "De La Fontaine", 'photo' => Null ],
            [ "idOeuvre" => 19 , "titre" => "le livre de la jungle" , "dateParution" => "1968-12-11" , "idAuteur" => "13" , "nomAuteur" => "Kipling", 'photo' => Null ],
            [ "idOeuvre" => 20 , "titre" => "kim" , "dateParution" => "1901-07-01" , "idAuteur" => "13" , "nomAuteur" => "Kipling", 'photo' => Null ],
            [ "idOeuvre" => 21 , "titre" => "le marin de Gibraltar" , "dateParution" => "1952-07-12" , "idAuteur" => "9" , "nomAuteur" => "Duras", 'photo' => Null ],
            [ "idOeuvre" => 22 , "titre" => "l’assommoir" , "dateParution" => "1976-01-01" , "idAuteur" => "11" , "nomAuteur" => "Zola", 'photo' => Null ],
            [ "idOeuvre" => 23 , "titre" => "j'accuse" , "dateParution" => "1898-01-13" , "idAuteur" => "11" , "nomAuteur" => "Zola", 'photo' => Null ],
            [ "idOeuvre" => 24 , "titre" => "la terre" , "dateParution" => "1887-01-01" , "idAuteur" => "11" , "nomAuteur" => "Zola", 'photo' => Null ]
        ];
        foreach ($tab_oeuvres as $oeuvres)
        {
            $new_oeuvre = new Oeuvre();
            $new_oeuvre->setTitre($oeuvres['titre']);
            $new_oeuvre->setDateParution(\DateTime::createFromFormat('Y-m-d', strtotime('dateParution')));
            $new_oeuvre->setNomAuteur($oeuvres['nomAuteur']);
            $new_oeuvre->setPhoto($oeuvres['photo']);
            $manager->persit($new_oeuvre);
            echo "titre : ".$new_oeuvre."\n";
        }
        $manager->flush();
    }

    public function load_exemplaires($manager)
    {
        $tab_exemplaires=[
            [ "idExemplaire" => 1 , "etat" => "BON" , "dateAchat" => "2019-08-25" , "prix" => "13.5" , "idOeuvre" => "1" , "titre" => "le retour de Poirot"],
            [ "idExemplaire" => 2 , "etat" => "MOYEN" , "dateAchat" => "2012-09-28" , "prix" => "12.5" , "idOeuvre" => "1" , "titre" => "le retour de Poirot"],
            [ "idExemplaire" => 3 , "etat" => "MOYEN" , "dateAchat" => "2019-05-26" , "prix" => "12" , "idOeuvre" => "1" , "titre" => "le retour de Poirot"],
            [ "idExemplaire" => 4 , "etat" => "BON" , "dateAchat" => "2012-01-11" , "prix" => "10" , "idOeuvre" => "1" , "titre" => "le retour de Poirot"],
            [ "idExemplaire" => 5 , "etat" => "MAUVAIS" , "dateAchat" => "2019-10-29" , "prix" => "13" , "idOeuvre" => "2" , "titre" => "Poirot quitte la scène"],
            [ "idExemplaire" => 6 , "etat" => "NEUF" , "dateAchat" => "2019-10-29" , "prix" => "20" , "idOeuvre" => "2" , "titre" => "Poirot quitte la scène"],
            [ "idExemplaire" => 7 , "etat" => "BON" , "dateAchat" => "2019-12-27" , "prix" => "7" , "idOeuvre" => "3" , "titre" => "dix brèves rencontres"],
            [ "idExemplaire" => 8 , "etat" => "MOYEN" , "dateAchat" => "2019-09-25" , "prix" => "13" , "idOeuvre" => "3" , "titre" => "dix brèves rencontres"],
            [ "idExemplaire" => 9 , "etat" => "NEUF" , "dateAchat" => "2012-12-29" , "prix" => "18" , "idOeuvre" => "4" , "titre" => "le miroir de la mort"],
            [ "idExemplaire" => 10 , "etat" => "NEUF" , "dateAchat" => "2012-12-29" , "prix" => "21" , "idOeuvre" => "4" , "titre" => "le miroir de la mort"],
            [ "idExemplaire" => 11 , "etat" => "BON" , "dateAchat" => "2012-04-29" , "prix" => "26" , "idOeuvre" => "4" , "titre" => "le miroir de la mort"],
            [ "idExemplaire" => 12 , "etat" => "MAUVAIS" , "dateAchat" => "2019-10-27" , "prix" => "22" , "idOeuvre" => "5" , "titre" => "paroles"],
            [ "idExemplaire" => 13 , "etat" => "BON" , "dateAchat" => "2019-01-24" , "prix" => "22" , "idOeuvre" => "6" , "titre" => "une créature de rêve"],
            [ "idExemplaire" => 14 , "etat" => "BON" , "dateAchat" => "2019-05-01" , "prix" => "28" , "idOeuvre" => "7" , "titre" => "mémoire d'outre-tombe"],
            [ "idExemplaire" => 15 , "etat" => "MAUVAIS" , "dateAchat" => "2019-01-26" , "prix" => "28" , "idOeuvre" => "7" , "titre" => "mémoire d'outre-tombe"],
            [ "idExemplaire" => 16 , "etat" => "BON" , "dateAchat" => "2019-01-24" , "prix" => "30" , "idOeuvre" => "8" , "titre" => "Madame de Bovary"],
            [ "idExemplaire" => 17 , "etat" => "BON" , "dateAchat" => "2019-01-23" , "prix" => "32" , "idOeuvre" => "9" , "titre" => "un amour de swam"],
            [ "idExemplaire" => 18 , "etat" => "MAUVAIS" , "dateAchat" => "2012-01-29" , "prix" => "17" , "idOeuvre" => "10" , "titre" => "les femmes savantes"],
            [ "idExemplaire" => 19 , "etat" => "BON" , "dateAchat" => "2019-10-29" , "prix" => "18" , "idOeuvre" => "10" , "titre" => "les femmes savantes"],
            [ "idExemplaire" => 20 , "etat" => "BON" , "dateAchat" => "2019-10-29" , "prix" => "18" , "idOeuvre" => "10" , "titre" => "les femmes savantes"],
            [ "idExemplaire" => 21 , "etat" => "BON" , "dateAchat" => "2019-10-29" , "prix" => "19" , "idOeuvre" => "10" , "titre" => "les femmes savantes"],
            [ "idExemplaire" => 22 , "etat" => "BON" , "dateAchat" => "2019-01-26" , "prix" => "20" , "idOeuvre" => "11" , "titre" => "le misanthrope"],
            [ "idExemplaire" => 23 , "etat" => "BON" , "dateAchat" => "2019-10-29" , "prix" => "21.5"  , "idOeuvre" => "12" , "titre" => "Les fleurs du mal"],
            [ "idExemplaire" => 24 , "etat" => "MAUVAIS" , "dateAchat" => "2019-01-24" , "prix" => "22" , "idOeuvre" => "13" , "titre" => "petits poèmes en prose"],
            [ "idExemplaire" => 25 , "etat" => "BON" , "dateAchat" => "2012-01-28" , "prix" => "22" , "idOeuvre" => "13" , "titre" => "petits poèmes en prose"],
            [ "idExemplaire" => 26 , "etat" => "MAUVAIS" , "dateAchat" => "2019-01-23" , "prix" => "26" , "idOeuvre" => "14" , "titre" => "les mondes perdus"],
            [ "idExemplaire" => 27 , "etat" => "MOYEN" , "dateAchat" => "2012-12-26" , "prix" => "13" , "idOeuvre" => "14" , "titre" => "les mondes perdus"],
            [ "idExemplaire" => 28 , "etat" => "BON" , "dateAchat" => "2019-02-23" , "prix" => "12" , "idOeuvre" => "15" , "titre" => "La guerre des mondes"],
            [ "idExemplaire" => 29 , "etat" => "BON" , "dateAchat" => "2019-10-29" , "prix" => "15" , "idOeuvre" => "15" , "titre" => "La guerre des mondes"],
            [ "idExemplaire" => 30 , "etat" => "MAUVAIS" , "dateAchat" => "2019-01-26" , "prix" => "32" , "idOeuvre" => "16" , "titre" => "spectacles"],
            [ "idExemplaire" => 31 , "etat" => "BON" , "dateAchat" => "2019-01-23" , "prix" => "19" , "idOeuvre" => "17" , "titre" => "Les fables"],
            [ "idExemplaire" => 32 , "etat" => "MAUVAIS" , "dateAchat" => "2016-10-29" , "prix" => "19" , "idOeuvre" => "17" , "titre" => "Les fables"],
            [ "idExemplaire" => 33 , "etat" => "BON" , "dateAchat" => "2019-01-23" , "prix" => "20" , "idOeuvre" => "19" , "titre" => "le livre de la jungle"],
            [ "idExemplaire" => 34 , "etat" => "BON" , "dateAchat" => "2019-01-25" , "prix" => "11" , "idOeuvre" => "19" , "titre" => "le livre de la jungle"],
            [ "idExemplaire" => 35 , "etat" => "MAUVAIS" , "dateAchat" => "2019-10-29" , "prix" => "15" , "idOeuvre" => "19" , "titre" => "le livre de la jungle"],
            [ "idExemplaire" => 36 , "etat" => "NEUF" , "dateAchat" => "2019-10-29" , "prix" => "18" , "idOeuvre" => "19" , "titre" => "le livre de la jungle"],
            [ "idExemplaire" => 37 , "etat" => "BON" , "dateAchat" => "2019-01-23" , "prix" => "8" , "idOeuvre" => "19" , "titre" => "le livre de la jungle"],
            [ "idExemplaire" => 38 , "etat" => "MAUVAIS" , "dateAchat" => "2019-09-28"  , "prix" => "18" , "idOeuvre" => "20" , "titre" => "kim"],
            [ "idExemplaire" => 39 , "etat" => "BON" , "dateAchat" => "2019-12-26" , "prix" => "18" , "idOeuvre" => "20" , "titre" => "kim"],
            [ "idExemplaire" => 40 , "etat" => "BON" , "dateAchat" => "2019-01-23" , "prix" => "11" , "idOeuvre" => "20" , "titre" => "kim"]
        ];
        foreach ($tab_exemplaires as $exemplaire)
        {
            $new_exemplaire = new Exemplaire();
            $new_exemplaire->setEtat($exemplaire['etat']);
            $new_exemplaire->setDateAchat(\DateTime::createFromFormat('Y-m-d', strtotime('dateAchat')));
            $new_exemplaire->setPrix($exemplaire['prix']);
            $new_exemplaire->setOeuvre($exemplaire['idOeuvre']);
            $manager->persit($new_exemplaire);
            echo "exemplaire : ".$new_exemplaire."\n";
        }
        $manager->flush();
    }

    public function load_umprunt($manager)
    {
        $tab_emprunts=[
            [ "idAdherent" =>3 , "idExemplaire" => 9 , "dateEmprunt" => "2020-01-25" , "dateRetour" => "2020-02-30"],
            [ "idAdherent" =>4 , "idExemplaire" => 6 , "dateEmprunt" => "2020-01-22" , "dateRetour" => "2020-01-23"],
            [ "idAdherent" =>3 , "idExemplaire" => 7 , "dateEmprunt" => "2020-02-22" , "dateRetour" => "2020-03-29"],
            [ "idAdherent" =>2 , "idExemplaire" => 19 , "dateEmprunt" => "2020-02-26" , "dateRetour" => "2020-02-31"],
            [ "idAdherent" =>4 , "idExemplaire" => 34 , "dateEmprunt" => "2020-01-23" , "dateRetour" => "2020-02-20"],
            [ "idAdherent" =>3 , "idExemplaire" => 11 , "dateEmprunt" => "2020-01-26" , "dateRetour" => "2020-02-21"],
            [ "idAdherent" =>2 , "idExemplaire" => 40 , "dateEmprunt" => "2020-01-23" , "dateRetour" => "2020-02-23"],
            [ "idAdherent" =>3 , "idExemplaire" => 5 , "dateEmprunt" => "2019-07-26" , "dateRetour" => "2019-08-23"],
            [ "idAdherent" =>2 , "idExemplaire" => 35 , "dateEmprunt" => "2019-07-13" , "dateRetour" => "2019-09-21"],
            [ "idAdherent" =>5 , "idExemplaire" => 40 , "dateEmprunt" => "2019-07-25" , "dateRetour" => "2019-09-22"],
            [ "idAdherent" =>8 , "idExemplaire" => 9 , "dateEmprunt" => "2019-07-26" , "dateRetour" => "2019-09-22"],
            [ "idAdherent" =>5 , "idExemplaire" => 12 , "dateEmprunt" => "2019-07-25" , "dateRetour" => "2019-09-23"],
            [ "idAdherent" =>2 , "idExemplaire" => 5 , "dateEmprunt" => "2019-08-23" , "dateRetour" => "2019-09-23"],
            [ "idAdherent" =>6 , "idExemplaire" => 15 , "dateEmprunt" => "2019-09-23" , "dateRetour" => "2019-09-26"],
            [ "idAdherent" =>6 , "idExemplaire" => 2 , "dateEmprunt" => "2019-09-21" , "dateRetour" => "2019-09-28"],
            [ "idAdherent" =>7 , "idExemplaire" => 2 , "dateEmprunt" => "2019-10-21" , "dateRetour" => "2019-10-28"],
            [ "idAdherent" =>8 , "idExemplaire" => 2 , "dateEmprunt" => "2019-11-21" , "dateRetour" => "2019-11-28"],
            [ "idAdherent" =>7 , "idExemplaire" => 38 , "dateEmprunt" => "2019-07-26" , "dateRetour" => "2019-10-22"],
            [ "idAdherent" =>2 , "idExemplaire" => 18 , "dateEmprunt" => "2019-09-23" , "dateRetour" => "2019-10-28"],
            [ "idAdherent" =>3 , "idExemplaire" => 5 , "dateEmprunt" => "2019-11-23" , "dateRetour" => "2019-12-24"],
            [ "idAdherent" =>3 , "idExemplaire" => 40 , "dateEmprunt" => "2019-11-23" , "dateRetour" => "2019-12-24"],
            [ "idAdherent" =>2 , "idExemplaire" => 37 , "dateEmprunt" => "2020-02-11" , "dateRetour" => ""],
            [ "idAdherent" =>4 , "idExemplaire" => 27 , "dateEmprunt" => "2020-02-22" , "dateRetour" => ""],
            [ "idAdherent" =>4 , "idExemplaire" => 6 , "dateEmprunt" => "2020-01-25" , "dateRetour" => ""],
            [ "idAdherent" =>3 , "idExemplaire" => 33 , "dateEmprunt" => "2020-01-30" , "dateRetour" => ""],
            [ "idAdherent" =>3 , "idExemplaire" => 13 , "dateEmprunt" => "2020-01-04" , "dateRetour" => ""],
            [ "idAdherent" =>3 , "idExemplaire" => 3 , "dateEmprunt" => "2019-09-13" , "dateRetour" => ""],
            [ "idAdherent" =>4 , "idExemplaire" => 19 , "dateEmprunt" => "2019-09-21" , "dateRetour" => ""],
            [ "idAdherent" =>2 , "idExemplaire" => 5 , "dateEmprunt" => "2019-12-15" , "dateRetour" => ""],
            [ "idAdherent" =>2 , "idExemplaire" => 4 , "dateEmprunt" => "2019-12-01" , "dateRetour" => ""],
            [ "idAdherent" =>2 , "idExemplaire" => 8 , "dateEmprunt" => "2019-12-30" , "dateRetour" => ""]
        ];
        foreach ($tab_emprunts as $emprunt)
        {
            $new_emprunt = new Emprunt();
            $new_emprunt->setDateEmprunt(\DateTime::createFromFormat('Y-m-d', strtotime('dateEmprunt')));
            $new_emprunt->setDateRetour(\DateTime::createFromFormat('Y-m-d', strtotime('dateRetour')));
            $manager->persit($new_emprunt);
            echo "emprunt : ".$new_emprunt."\n";
        }
        $manager->flush();
    }

}
