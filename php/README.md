# Documentation
## API (/api.php)
### Anonymous access modules list
- auth: user authentication
- package: retrieve information from the database
- registration: user registration

### Require authentication and authorization modules list
- db: crud operations on the project database
- whoami: provide informations about the user
- packaging: package existing information from the database at the attention of anonymous usage

#### API snythax
-> Examples
- auth: /api.php?cmd=auth&token=[user token] . Result: give a session token if the user token is valid
- whoami: /api.php?cmd=whoami&session_token=[session token]. Result: give information about the authenticated user if the session token is valid

## public links
- /api.php
- /login.php
- /index.php
- /register.php

## Configuration
/config/config.system.php
- system database connection information
- system debug mode 

/config/config.project.php
- project database connection information
- project name, version, main contact
- git links
- default main site language

/databases/
- contains system and project databases
