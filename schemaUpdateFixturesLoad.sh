## Créer un script schemaUpdateFixturesLoad.sh avec comme contenu :

php bin/console doctrine:query:sql "DROP TABLE IF EXISTS emprunt, exemplaire, oeuvre, adherent, auteur"
php bin/console doctrine:schema:update  --force
php bin/console doctrine:fixtures:load  --verbose --no-interaction

