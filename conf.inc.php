<?php


define("DBUSER","root");
define("DBPWD","password");
define("DBHOST","database");
define("DBNAME","mvcdocker");
define("DBPORT","3306");


define("DS", "/");

//dirname($_SERVER["SCRIPT_NAME"]) => /3IW classe 2/
//dirname($_SERVER["SCRIPT_NAME"]) => //
$scriptName = (dirname($_SERVER["SCRIPT_NAME"]) == DS)?"":dirname($_SERVER["SCRIPT_NAME"]);
define("DIRNAME", $scriptName.DS);