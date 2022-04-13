
<?php 
 //Errors Reporting
 ini_set('display_errors', 'On');
 error_reporting(E_ALL);




 include 'admin/connect.php';


 // Routes 

 $tpl 	= 'includes/templates/';
 $lang	= 'includes/lang/';
 $func  = 'includes/functions/';
 $css   = 'layout/css/';
 $js 	= 'layout/js/';

$sessionUser='dadadada';
if (isset($_SESSION['user'])) {
$sessionUser=$_SESSION['user'];	
}




 // include important Files

 
 include $lang.'english.php';
 include $func.'functions.php';
 include $tpl.'header.php';
if (!isset($noNavbar)) {
    include $tpl . 'navbar.php';
 }

 