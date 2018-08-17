<?php 

require_once('mysql.php');


if(!isset($_SESSION['candidate_id']))
{
	header('location:login.php');
}


session_unset();
session_destroy();

header('location:login.php');

?>