<?php

function lang($phrase){

static $lang = 
array(
	'message' =>"Welcome arabic" ,
	'Home' =>"Home page but in arabic" 
);

return $lang[$phrase];
}
