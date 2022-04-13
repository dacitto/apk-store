<?php

function lang($phrase){

static $lang = 
array(
	        'HOME_ADMIN' 	=> 'Apk Store',
			'CATEGORIES' 	=> 'Categories',
			'APPS' 	    	=> 'Apps',
			'MEMBERS' 		=> 'Members',
			'COMMENTS'		=> 'Comments',
			'STATISTICS' 	=> 'Statistics',
			'LOGS' 			=> 'Logs',
			'' => '',
			'' => ''
);

return ($lang[$phrase]);
}





