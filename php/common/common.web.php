<?php
// https require a certificate
const http_security = 'https';
const http_get = 'get';
const http_post = 'post';
const http_no_security = 'http';
const http_verbs_allowed = [http_get, http_post];

/*
 * api parameters
 * */
const api_cmd = 'cmd';
const api_result = 'result';
const api_username = 'username';

/*
 * The token is used to authenticate the user.
 * It is given by the user when the user wants to authenticate.
 * */
const api_token = 'token';

/*
 * The session token is given when the user is authenticated.
 * It is used to authenticate the user for requests.
 * */
const api_session_token = 'session_token';

const web_session_loggedIn = 'loggedin';
const web_csrf = 'csrf';


# api url
const web_base_url = http_no_security . '://' . 'localhost/' . 'turbo-octo-lamp/';

# url
const web_api_url = web_base_url . 'php' . '/api.php';
const web_admin_url = web_base_url . 'php' . '/admin.php';
const web_login_url = web_base_url . 'php' . '/login.php';
const web_index_url = web_base_url . 'php' . '/index.php';
const web_register_url = web_base_url . 'php' . '/register.php';
const web_status_url = web_base_url . 'php' . '/status.php';