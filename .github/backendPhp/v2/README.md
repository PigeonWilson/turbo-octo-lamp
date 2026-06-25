# Documentation
La phase 1 implémente un accès CRUD via un script php pour une base de données mySQL. 

# Verbes http
Le script php utilise le verbe $_REQUEST. Tous les verbes http sont supportés

# Modules toujours requis
- db (utilisé pour login)
## Parametres requis pour db
- username
- token
- arg
- table
- data
## verbes permis
- c ou create
- r ou read
- u ou update
- d ou delete

## Exemple
Exemple: /?username=[username]&token=[token]&cmd=db&arg=create&[parametres optionnels qui dependent de la table]
ou http://localhost/turbo-octo-lamp/.github/backendPhp/v2/?cmd=db&arg=c&username=test&token=test&table=storage&uniqueid=star123&data=fist%20entry

retournerait: 
{
    "operationResult": true,
    "lastInsertedId": "10"
}


# Paramètres toujours requis
- username (utilisé pour login)
- token (utilisé pour login)

# Modules optionnels
