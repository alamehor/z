<?php
//dependency import
require 'properties.php';
require 'lib/Slim/Slim.php';
require 'security/Security.php';

//init Slim Framework
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->add(new \Security($app));
require 'security/Login.php';
require 'security/ManageUser.php';

//resources
	//db z_db
		require('./resource/z_db/custom/ArticleCustom.php');
		require('./resource/z_db/Article.php');
		require('./resource/z_db/custom/MediaCustom.php');
		require('./resource/z_db/Media.php');
		require('./resource/z_db/custom/UserCustom.php');
		require('./resource/z_db/User.php');
	

$app->run();


?>
