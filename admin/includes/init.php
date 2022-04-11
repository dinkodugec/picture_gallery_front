<?php


defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);  //The defined() function checks whether a constant exists.

define('SITE_ROOT',__DIR__.DS.'..'.DS.'..');


/* defined('SITE_ROOT') ? null : define('SITE_ROOT', DS . 'XAMPP' . DS . 'htdocs' . DS . 'gallery');

defined('INCLUDES_PATH') ? null : define('INCLUDES_PATH', SITE_ROOT.DS.'admin'.DS.'includes'); */

require_once("functions.php");
require_once("new_config.php");
require_once("database.php");
require_once("db_object.php");
require_once("user.php");
require_once("comment.php"); 
require_once("photo.php");
require_once("session.php");
require_once("paginate.php");

/* includes giv us warning not failure like require_once, require_once is more secure*/

?>