<?php
ob_start();
session_start();
 	$pageTitle = '';
 	if(isset($_SESSION['UserName'])){
 		//
       include 'init.php';

       //code begin
      $do = isset($_GET['do']) ? $_GET['do'] : 'manage' ;

if ($do == 'manage'){  

      
}elseif ($do == 'add') {

}elseif ($do =='Insert') {

}elseif ($do == 'edit') {

}elseif($do == "Update"){

}elseif ($do=="delete") {
	
}elseif ($do=="approve") {
}
    //end
       include $tpl.'footer.php';

 	}
 	else{

 		header('Location: index.php');
 		exit();}
 	
 	ob_end_flush();