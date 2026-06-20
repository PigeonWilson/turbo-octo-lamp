# ClientPython

ClientPython est le composant Python du projet `turbo-octo-lamp`.

Son rôle principal est de fournir des outils réutilisables par le backend PHP, notamment pour générer un site statique à partir de fichiers de données JSON et de gabarits HTML.

## Objectif

Le client Python doit permettre de:

- lire des fichiers JSON contenant les données du site;
- valider la structure des données avant génération;
- combiner ces données avec des gabarits HTML;
- produire des fichiers HTML statiques;
- offrir une interface simple pouvant être appelée par le backend PHP;
- éventuellement intégrer certaines opérations Git nécessaires au cycle de publication.

## Rôle dans le projet

Le projet complet n’est pas uniquement une application en ligne de commande. Il est composé de plusieurs parties:

- un backend PHP responsable de l’API et des modules applicatifs;
- des gabarits HTML pour l’affichage;
- ce client Python, utilisé comme composant technique pour certaines tâches de génération, validation et publication.

ClientPython doit donc rester utilisable comme bibliothèque Python, même si une interface en ligne de commande peut être ajoutée pour faciliter son exécution depuis PHP ou depuis un terminal.

## Fonctionnalités prévues

### Génération statique

Générer des pages HTML à partir de:

- fichiers JSON;
- gabarits HTML;
- répertoire de sortie configuré.

### Validation JSON

Vérifier que les fichiers de données respectent la structure attendue avant de générer le site.

### Intégration Git

Prévoir des fonctions permettant d’interagir avec un dépôt Git lorsque nécessaire, par exemple pour mettre à jour des données ou préparer une publication.

## Communication avec le backend PHP

Pour la communication avec le backend PHP, une première approche à tester est l’utilisation de requêtes HTTP vers `endpoint.php`.

Exemple de requête pour enregistrer un client ou un utilisateur:

```text
/endpoint.php?action=register&username=[ton username]
```

Exemple de requête pour se connecter:

```text
/endpoint.php?action=connect&username=[ton username]&token=[le token reçu lors de l’enregistrement]
```

La réponse attendue est au format JSON.

## État actuel

Ce composant est en phase de démarrage. La structure exacte du code, les commandes disponibles et les formats de données restent à définir.

## Développement

Une première version minimale devrait viser à:

1. charger un fichier JSON;
2. charger un gabarit HTML;
3. générer une page HTML;
4. écrire le résultat dans un dossier de sortie;
5. exposer cette logique dans une fonction Python réutilisable.

Une interface en ligne de commande pourra ensuite appeler cette logique, sans devenir le cœur du projet.

## Licence

Voir la licence du dépôt principal.
