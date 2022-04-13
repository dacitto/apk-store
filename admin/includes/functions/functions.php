<?php  

/* Title Function 
               echo PageTitle is there is var $pageTitle in the Page
               and echo defulte title for the other pages

*/

 function echoTitle(){
          global $pageTitle;
 	if (isset($pageTitle)){
 		echo $pageTitle;
 	}
 	else
 		echo "AppStorm";
 }

 /*index redirect Function( param)  V2.0.1 
   

 */
 function redirect($message='',$url = null ,$seconds = 2){
 	 if ($url=== null) {
 	 	$url='index.php';
 	 }else{
 	 	if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']!='') {
 	 	
 	 	$url=$_SERVER['HTTP_REFERER'];
 	 	}else
 	 	$url='index.php';
 	 }
         
         echo "<div class='alert alert-danger'> $message </div>";
         echo "<div class='alert alert-info'>You well be redurect after ".$seconds." seconds</div>";
         header("refresh:$seconds;url=$url");
         exit();
 } 

/*    Check items Function 
      ====================
 	$select = the item to select  (username ,item ,fullname ...)
 	$from   = the table to select (users , items ....)
 	$value  = the value of select (Box , (category) )
*/

 	

  function checkItem($select,$from,$value){
    global $con;
    $stat  = $con->prepare("SELECT $select FROM $from WHERE  $select = ? ");
    
    $stat->execute(array($value));
    
    $count = $stat->rowCount();
    return $count;

  }

 	/*
 	Items Number function */
 	function countItems($item,$table){
 		global $con;
 		$stmt2 = $con->prepare("SELECT COUNT($item) FROM $table"); // members Number
        $stmt2->execute();
        return $stmt2->fetchColumn();
 	}
  
  /*
     GET LATEST ITEMS FROM DATA BASE 
     (USERS ,ITEMS ,COMMENTS )
 */
   
   function getLatest($select,$from,$limit = 5,$order = ""){
   	global $con;
   	$getStmt = $con->prepare("SELECT $select FROM $from ORDER BY $order DESC  LIMIT $limit");

   	$getStmt->execute();

   	$rows = $getStmt->fetchAll();

   	return $rows;

   }

 function getTable($table,$where='',$val=''){
     global $con;
     if ($where!=='') {
       $where = "WHERE ".$where.'=?';
     }
    $getStmt = $con->prepare("SELECT * FROM $table $where ");

    $getStmt->execute(array($val));

    $rows = $getStmt->fetchAll();

    return $rows;
   }


   
function getAllFrom($field, $table, $where = NULL, $and = NULL, $orderfield='', $ordering = "DESC") {

    global $con;

    $getAll = $con->prepare("SELECT $field FROM $table $where $and ORDER BY $orderfield $ordering");

    $getAll->execute();

    $all = $getAll->fetchAll();

    return $all;

  }



  