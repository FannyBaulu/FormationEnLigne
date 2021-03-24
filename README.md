# Site de formation en ligne

Application permettant à l'utilisateur de créer des formations visionnable en ligne. Il permet aussi à celui-ci de pouvoir visionner les formations déjà présente sur le site et de garder un suivi de sa progression sur celles-ci.


## Requis:

Dans le but d'utiliser ce logiciel, vous aurez besoin de:
- Visual Studio Code
- MySQL Workbench
- Laravel 8.0 & Jetstream
- VueJS 2.9.6
- Inertia 0.3.5
- PHP 7.4

## Installation

Créer un schéma dans mySQL Workbench.
Remplir le .env avec le nom du schéma, et vos identifiants de connexion à la base de données.

Ajouter la ligne suivante dans votre .env :
YOUTUBE_API_KEY=""

Y insérerer votre clé API Youtube que vous pouvez récupérez sur le site de Google Cloud Platform (https://cloud.google.com/) de la manière suivante:
- Onglet Console
- Y créer un projet.Allez sur API et Services. Activer les api et services. Activer l'api suivante : Youtube Data API v3
- Génerer une clé API en allant modifié les paramètres de celle-ci pour enlever les restrictions liés à l'application (seulement si vous effectuez vos tests en local).

Pour évitez les erreurs SSL lors de la création de la formation, vous devez télécharger le fichier suivant:
http://curl.haxx.se/ca/cacert.pem
Allez ensuite modifier votre php.ini à la ligne:
curl.cainfo =
et ajouter le chemin vers le fichier que vous venez de télécharger.

Lancer:
`composer install` 
`npm install`
`php artisan key:generate`

Avant de lancer les migrations, allez dans le fichier Course.php (model) et vérifiez que la méthode "booted" est bien commentée.
`php artisan migrate`
`php artisan db:seed`
Une fois les migrations et seeders effectués, décommentez la fonction "booted".
Lancer le serveur:
`php artisan serve`
