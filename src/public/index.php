<?php 

use Aslam\Test\public\Request;
use Aslam\Test\public\App;
require_once '../../vendor/autoload.php';
require_once 'Session.php';
$request = new Request;
define('base_app', str_replace('\\','/',__DIR__).'/' );
define('base_url','http://localhost:8081/c44/Sun_Project%20(1)/Sun_Project/src/public/index.php?');
$app = new App($request);