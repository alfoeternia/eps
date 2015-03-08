Efrei Picture Studio v2.0
===

## Installation Windows

On commence par installer [wamp](http://wampserver.com), ou un truc du genre.

Puis on clone le repo dans un dossier dans www (pour ça il faut [git](https://msysgit.github.io/))

Une fois que c'est fait, on a deux choix, la rapide et crados, ou la lonueg et propre.

* Pour la longue et propre il s'agit d'installer composer pour recompiler le tout voir le [site du zéro](http://http://openclassrooms.com/courses/developpez-votre-site-web-avec-le-framework-symfony2)
Pareil pour bootstrap et pour les css compilé.
* Sinon la crade, on récupère le repertoire vendor du ftp, ainsi que le css compilé (utilisé pour la prod) dans www/css


Une fois cela fait, il va falloir créer la base de donnée :

* Aller sur mysql, créer une base de donnée avec le nom que vous voulez.
* Puis récupérer le fichier sql à la racine, importé le dans la base de donnée. Vous avez l'archi de la base de donnée.
Vous pouvez la remplir avec quelque donnée ou récupérer les données sur la base de donnée de prod.

Il faut ensuite créer votre fichier de paramètre dans 
```
wamp/www/EPS/app/config/parameters.yml 
```
(j'ai mis mon fichier de config pour l'exemple parameters.yml.dev.branlute)


* Après pour y acccéder
```
http://localhost/EPSV2/www/app_dev.php
```
 (pour le dev)

Et normalement c'est fini!!


## Installation Linux ou Mac

Tu as un Linux, donc tu sais faire, ou alors tu t'inspirse du dessus, pareil pour mac.



## Erreur courante

Si vous avez une 500 lors du lancement du site, c'est peu être a cause d'apache 2.4

Un petit tour dans les logs, si on a un : 
```
Invalid command 'AddOutputFilterByType'
```

* Il faut activer le module "filter_module" dans wamp : 
```
Apache => Apache modules => filter_module
```

Sinon je sais pas.