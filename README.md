# Initialisation du projet.
Pour pouvoir tester ce projet, il faudra initialiser composer et instaler dotenv.  
Il faudra ensuite créer un fichier .env.local e le personnaliser en partant du fichier .env  
  
  
# Le projet
Ce projet a pour but de créer une première API REST.  
Cette API permettra de gérer les acteurs et les rôles d'un spectable vivant.  
La base de données sera composée de deux tables, une acteurs et une rôle qui seront relier par une clé etrangère id_a dans la table rôle.
cette clé étrangère sera nullable au cas ou un acteur soit supprimé de la mise en scène, en attendant qu'on le remplace par un autre.
Pour ça j'ai mis une contrainte ON DELETE => NULL dans la bdd.  
  
Pour pouvoir gérer ces deux tables, l'API aura un crud sur chacune d'elles.  
  
# CRUD Actors
## première étape
J'ai d'abbord créé tout le crud dans l'index et vérifié le bon fonctionnement
![Texte alternatif](/chemin/access/image.jpg "Titre de l'image").

## deuxième étape
Création d'une class ActorsCrud dans un dossier Crud.
Je déplace le petit à petit le crud actor dans cette class en commençant par le read et le create pour les collection
![Texte alternatif](/chemin/access/image.jpg "Titre de l'image").
