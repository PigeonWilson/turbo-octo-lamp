<?php 
/* This file is auto-generated */
/*  The 'auth' module doesn't require authentication.  It provides a service to authenticate users.  It requires a token to open a session into the database  and it provides a token to authenticate the user for all requests  until the session is closed. The user session can be  terminated by the user or by the server.*/
const api_module_auth = "auth";

/*  The 'registration' module doesn't require authentication.  It provides a service to register new users.*/
const api_module_registration = "registration";

/* The 'db' module require authentication. It provides crud operations to the database and some other operations.*/
const api_module_db = "db";

/*  The 'whoami' module requires authentication.  It provides information about the user.*/
const api_module_whoami = "whoami";

/* The 'package' module doesn't require authentication. It provides information about the packages.*/
const api_module_package = "package";

/* The 'packaging' module requires authentication. It provides a service to decommission protected information into a format that is accessible to the public.*/
const api_module_packaging = "packaging";

?>