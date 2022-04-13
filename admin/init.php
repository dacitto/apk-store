<?php 
 
 include 'connect.php';


 // Routes 

 $tpl 	= 'includes/templates/';
 $lang	= 'includes/lang/';
 $func  = 'includes/functions/';
 $css   = 'layout/css/';
 $js 	= 'layout/js/';

 // include important Files

 
 include $lang.'english.php';
 include $func.'functions.php';
 include $tpl.'header.php';

 // include Navbar on noNavbar in all Pages With $NoNavbar

 if (!isset($noNavbar)) {
    include $tpl . 'navbar.php';
 }