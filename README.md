# Initialisation du projet.
Pour pouvoir tester ce projet, il faudra initialiser composer et instaler dotenv.  
  
Il faudra ensuite créer un fichier .env.local e le personnaliser en partant du fichier .env  
  
Dans phpMyAdmin, il faut créer une nouvelle Bdd spectacle et importer la bdd spectacle.sql du dossier data.  
  
# Le projet
Ce projet a pour but de créer une première API REST.  
Cette API permettra de gérer les acteurs et les rôles d'un spectable vivant.  
La base de données sera composée de deux tables, une acteurs et une rôle qui seront relier par une clé etrangère id_a dans la table rôle.  
Cette clé étrangère sera nullable au cas ou un acteur soit supprimé de la mise en scène, en attendant qu'on le remplace par un autre.  
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
- Pour le create et le update je n'ai pas le même nombre de colonnes dans chaque table et j'ai dû adapter la requête.  
  
- Pour le create j'ai utilisé des paramètres positionnels  
![crudCreate](/img/crud-create.png "crud create")
  
- Pour le update j'ai voulu utiliser la même méthode mais j'ai eu un soucis à cause de l'id que je nommais, j'ai donc utilisé une autre méthode pour n'utiliser que des paramètres nommés  
![crudUpdate](/img/crud-update.png "crud update")
  
# Création d'un CRUD Controller parent
  
j'ai créé un crudController parent dont les crudcontroller Actors et Role hériteront.  
  
## Problèmes rencontrés
- Dans mes cruds d'origine je pouvais directement définir un $actorCrud comme étant une instance de ActorCrud ou de RoleCrud.  
Avec cette nouvelle méthode j'ai dû définir un $crud dans un if.  
  
- Quand j'ai fais ce CRUD controller parent, au départ, j'ai tout mis et j'ai dû ajouter des conditions dans les if avec le nom de mes ressources dans les méthodes de POST et de PUT :  
![CrudController-avant-abstract](/img/CrudController-avant-abstract.png "CrudController-avant-abstract")  
  
- Pour éviter ça, j'ai choisi de transformer la class CrudController en class abstraite pour pouvoir passer ces méthodes en méthodes abstraites :  
![CrudController-après-abstract](/img/CrudController-après-abstract.png "CrudController-après-abstract")  
  
# Simplification du code
  
## Création d'une class HTTPMessageCode
Cette class regroupe les message HTTP que j'utilise dans cette API pour pouvoir les appeler plus clairement.  
  
## Création d'exceptions
Pour simplifier la lecture du code, création de plusieurs exceptions avec plusieurs héritages qui seront catch directement dans l'index.  
  
# Ajout d'un client JS

J'ai rapidement ajouté un client js mais je n'ai eu le temps de le faire que pour les rôles et il n'est pas du tout optimal.  
  
J'ai dû également ajouter un bout de code dans le fichier index.php pour que mon client puisse utiliser les méthodes put et delete.  
  
