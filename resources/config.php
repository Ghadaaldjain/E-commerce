<?php 

//Output buffering is a way to tell PHP to hold some data before it is sent to the browser. Then you can retrieve the data and put it in a variable, manipulate it, and send it to the browser once you’re finished.:
ob_start();

session_start();
//session_destroy();


//to work with any OS:
//DS = fowrward or back slash (debending on the os)
defined("DS") ? null : define("DS", DIRECTORY_SEPARATOR);

//define a path for back and front templetes:
defined("TEMPLATE_FRONT") ? null : define("TEMPLATE_FRONT", __DIR__ . DS . "templates/front");
defined("TEMPLATE_BACK") ? null : define("TEMPLATE_BACK", __DIR__ . DS . "templates/back");


defined("UPLOAD_DIRECTORY") ? null : define("UPLOAD_DIRECTORY", __DIR__ . DS . "uploads");
// DS = slash

//define db params:
defined("DB_HOST") ? null : define("DB_HOST", "localhost");
defined("DB_USER") ? null : define("DB_USER", "root");
defined("DB_PASS") ? null : define("DB_PASS","");
defined("DB_NAME") ? null : define("DB_NAME","ecom_db");

//create a connection to db:
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);




//to enable config to include all our function:
//so it can be avalible any where we include it
require_once("functions.php");
require_once("cart.php");


//echos the dirictory that I'm in :(it displays the dirctory; if the current file needed? __FILE__ is used)
// echo __DIR__;

?>