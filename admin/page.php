<?php

// $VAR = Condition ? true : false ;
$do='';

if (isset($_GET['do'])){
	$do = $_GET['do'];
	
}
else{
	$do = 'manage' ; 
}

if ($do == 'manage') {
	echo "You Are in Manage Page <br/>";
	echo "<a href='?do=add'>add new category +</a>";  //<a href='page?do=add'><a/>
}
elseif($do == 'add') {
	echo "You Are in add Page";
}
elseif($do == 'edit') {
	echo "You Are in edit Page";
}
elseif($do == 'remove') {
	echo "You Are in remove Page";
}
else 
  echo 'أخطيك مالتخلاط';
