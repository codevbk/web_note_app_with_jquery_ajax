<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
define('PROJECT_NAME', "web_note_app_with_jquery_ajax");
define('ROOT', dirname(__FILE__,2));
define('DOCUMENT_ROOT', dirname(__FILE__,1));
define('DOCUMENT_PUBLIC', DOCUMENT_ROOT."/public");
define('ASSETS_CSS', "/src/assets/css");
define('ASSETS_JS', "/src/assets/js");
define('COMPOSER_WEBSERVER', "localhost:8000");
define('NORMAL_WEBSERVER', "web_note_app_with_jquery_ajax");
define('HOST_URL', $_SERVER['REQUEST_URI']);
define('ONLINE', false);
define('ASSETS_OFFLINE_CSS', array(
"bootstrap.min.css",
"bootstrap-icons.min.css"));
define('ASSETS_ONLINE_CSS', array(
"https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.min.css",
"https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.4/font/bootstrap-icons.min.css"
));
define('ASSETS_OFFLINE_JS', array(
"jquery.min.js",
"bootstrap.min.js"
));
define('ASSETS_ONLINE_JS', array(
"https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js",
"https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.min.js"
));
?>