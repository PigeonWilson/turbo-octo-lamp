# Documentation
## API (/api.php)
### Anonymous access modules list
- auth: user authentication
- package: retrieve information from the database
- registration: user registration

### Require authentication and authorization modules list
- db: crud operations on the project database
- whoami: provide informations about a user
- packaging: package existing information from the database at the attention of anonymous usage

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
