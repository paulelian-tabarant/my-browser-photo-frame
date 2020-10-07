## Trucs importants

- Bien ajouter les droits d'exécution sur les dossiers utilisés dans les scripts (ex. phpFunctions, images...) à l'utilisateur courant par un `chmod 777 <dossier>`
- Pour pouvoir débugger en mode "ng serve", lancer Chrome avec la commande `google-chrome --disable-web-security --user-data-dir`
- Sur le serveur Apache, éditer .htaccess pour permettre les requêtes CORS en développement + les instructions de Rewrite pour pouvoir accéder aux scripts PHP sans avoir à écrire l'extension .php
- Dans les fichiers de config de PHP (/etc/php7.4/apache2/php.ini), modifier la valeur par défaut de la variable session.auto_start (passer de 0 à 1) pour pouvoir gérer des sessions utilisateur
- Pour conserver les cookies de session dans l'appli client, ne pas oublier l'option `{ withCredentials: true }` dans les requêtes HTTP
- Vérifier la cohérence de la base de données avec le code PHP du serveur (contraintes sur les champs, password en SHA512)
- Utilisateur par défaut base de données : admin, admin

## Notes diverses

- CORS
- Bien encoder les URI pour éviter les problèmes de caractères (encodeUri)
