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
![Tout dans index](/img/all-index.png "all-index").

## deuxième étape
Création d'une class ActorsCrud dans un dossier Crud.
Je déplace le petit à petit le crud actor dans cette class en commençant par le read et le create pour les collection
![class ActorsCrud](/img/class-ActorsCrud.png "ActorsCrud").

## troisième étape
Création d'une class ActorsCrudController qui va se charger de tous les controles du traitement de la requête et d'appeler ActorsCrud et ses méthodes.  
ActrosCrud ne fera plus que communiquer avec la BDD.  
Pendant cette étape j'ai aussi déporté le gestionnaire d'exception de l'index à une class et j'ai ajouté l'affichage du fichier et de la ligne de l'erreur pour plus de praticité pendant le codage.  
![class ActorsCrudController](/img/class-ActorsCrudController.png "ActorsCrudController")
![class ActorsCrud modifiée](/img/new-class-ActorsCrud.png "new-ActorsCrud")

# CRUD Roles
J'ai créé un CrudRoles et un CrudRoleController sur le même modele que le CrudActor

# Création d'un CRUD parent

j'ai décidé de créer un crud parent dont les Cruds Actor et Roles hériteront.

## Problèmes rencontrés
Pour le create et le update je n'ai pas le même nombre de colonnes dans chaque table et j'ai dû adapter la requête.  

Pour le create j'ai utilisé des paramètres positionnels  
![crudCreate](/img/crud-create.png "crud create")

Pour le update j'ai voulu utiliser la même méthode mais j'ai eu un soucis à cause de l'id que je nommais, j'ai donc utilisé une autre méthode pour n'utiliser que des paramètres nommés  
![crudUpdate](/img/crud-update.png "crud update")

