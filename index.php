<?php

$g_page_defaut = 'home';
$g_page_nofound = '404';

$g_pages = [
	'home' =>		['',			'pages/home.php'],
	'404' =>		['404',			'pages/404.php'],
];

// ----- INIT -----

require('class/DataBase.class.php');

DataBase::init( array(
	'server' => 'localhost',
	'name' => 'rush01',
	'username' => 'root',
	'password' => '123456'
));


// ----- ROOT -----

$g_page = $g_page_defaut;
$g_path = [];

if (isset($_GET['path']) && $_GET['path'] != '')
{
	if (!($g_page = path_to_page($_GET['path'], $g_path)))
	{
		$g_page = $g_page_nofound;
		$g_page_datas = $g_pages[$g_page];
	}
}

$g_page_datas = array_combine([
	'match',
	'file'
], $g_pages[$g_page]);


// ----- USER -----

$g_user = NULL;

session_start();
if (isset($_SESSION['user']))
	$g_user = $_SESSION['user'];
else
	$_SESSION['user'] = NULL;


// ----- PAGE -----

header('Content-Type: text/html; charset=utf-8');

include('pages/header.php');

if (file_exists($g_page_datas['file']))
	include($g_page_datas['file']);

include('pages/footer.php');

?>