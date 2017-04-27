<?php
	session_start();
	ob_start();
	
	header("Content-Type: text/html; charset=UTF-8",true);

	require "libs/Config.php";
	require "libs/Router.php";
	require "libs/Database.php";
	require "libs/Model.php";
	require "libs/Controller.php";
	require "libs/View.php";

	$c = new Config;
	define("ROOT", $c->mainURL);

	$route = new Router($_REQUEST);
	$route->go();
?>