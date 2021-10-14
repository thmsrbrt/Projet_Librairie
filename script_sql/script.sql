drop table if exists emprunt;
drop table if exists exemplaire;
drop table if exists oeuvre;
drop table if exists auteur;
drop table if exists adherent;

create table if not exists adherent (
                                        id int auto_increment
    , nom varchar(255)
    , adresse varchar(255)
    , date_paiement date
    , primary key (id)
);

create table if not exists auteur (
                                      id int auto_increment
    , nom varchar(255)
    , prenom varchar(255)
    , primary key (id)
);

create table if not exists oeuvre (
                                      id int auto_increment
    , titre varchar(255)
    , date_parution date
    , photo varchar(255)
    , auteur_id int
    , primary key (id)
    , constraint fk_oeuvre_auteur foreign key (auteur_id) references auteur(id)
);

create table if not exists exemplaire (
                                          id int auto_increment
    , etat varchar(255)
    , date_achat date
    , prix numeric
    , oeuvre_id int
    , primary key (id)
    , constraint fk_exemplaire_oeuvre foreign key (oeuvre_id) references oeuvre(id)
);

create table if not exists emprunt (
                                       adherent_id int
    , exemplaire_id varchar(50)
    , date_emprunt date
    , date_retour date
    , primary key (adherent_id, exemplaire_id, date_emprunt)
    , constraint fk_emprunt_adherent foreign key (adherent_id) references adherent(id)
    , constraint fk_emprunt_exemplaire foreign key (exemplaire_id) references exemplaire(id)
);

LOAD DATA LOCAL INFILE 'bdd/ADHERENT.csv' INTO TABLE adherent FIELDS TERMINATED BY ',';
LOAD DATA LOCAL INFILE 'bdd/AUTEUR.csv' INTO TABLE auteur FIELDS TERMINATED BY ',';
LOAD DATA LOCAL INFILE 'bdd/OEUVRE.csv' INTO TABLE oeuvre FIELDS TERMINATED BY ',';
LOAD DATA LOCAL INFILE 'bdd/EXEMPLAIRE.csv' INTO TABLE exemplaire FIELDS TERMINATED BY ',';
LOAD DATA LOCAL INFILE 'bdd/EMPRUNT.csv' INTO TABLE emprunt FIELDS TERMINATED BY ',';

#SHOW VARIABLES LIKE 'sql_mode';
# fonctionne sur la base normal, load completed
