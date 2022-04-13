<?php

/*
 Add - edit - delete  members from here

 */

 	session_start();
 	$pageTitle = 'Comments';
 	if(isset($_SESSION['UserName'])){
 		//
       include 'init.php';

       //code begin
       $do = isset($_GET['do']) ? $_GET['do'] : 'manage' ;

if ($do == 'manage'){         // 
        
       	$stmt = $con->prepare("SELECT comments.*,users.UserName , items.Name AS ItemName FROM comments
                   INNER JOIN 
                   items
                   ON 
                     items.Item_ID = comments.Item_Id 
                   INNER JOIN
                   users
                   ON
                     users.UserID = comments.User_Id
                     ORDER BY C_ID DESC 
          "); 

       	$stmt->execute();

       	$rows = $stmt->fetchAll();
       	?>
        <h1 class="text-center">Manage Comments </h1>;
        <div class ="container">
        <div calss ="table-responsive">
        <table class="main-table table table-bordered text-center">
            	<tr>
        	    <td>#ID</td>
        	    <td>Comment</td>
              <td>Added Date</td>
              <td>User Name</td>
              <td>Item Name</td>
        	    <td>Control</td>
            	</tr>
         <?php 
                 foreach ($rows as $row) {
                 echo "<tr> ";
                 echo '<td>'.$row['C_ID'].'</td>';
                 echo '<td>'.$row['Comment']."</td>";
                 echo '<td>'.$row['Comment_Date'].'</td>';
                 echo '<td>'.$row['UserName'].'</td>';
                 echo '<td>'.$row['ItemName'].'</td>';
                 echo '<td><a href="?do=edit&C_ID='.$row['C_ID'].'" class="btn btn-primary"><i class="fa fa-edit "></i> Edit</a>
                 <a href="?do=delete&C_ID='.$row['C_ID'].'" class="btn btn-danger confirm"><i class="fa fa-close"></i> Delete</a>
                 ';
                if ($row['Status']==0){
                  echo '<a href="?do=activate&C_ID='.$row['C_ID'].'"; class="btn btn-info activate"><i class="fa fa-exclamation"></i> Activate</a>';
                }
                echo'</td>';

              echo "</tr>";  



              }

         ?>
        </table>
        </div>

        </div>
       <?php 
       
      }elseif ($do == 'edit') { //edit page
            $C_ID = isset($_GET['C_ID']) && is_numeric($_GET['C_ID']) ? intval($_GET['C_ID']) : 0 ;

       $stmt = $con->prepare("SELECT *
            FROM comments WHERE C_ID = ?
            LIMIT 1 ");


      $stmt->execute(array($C_ID));
      $row = $stmt->fetch();
      $count = $stmt->rowCount();


      if ($count>0) {     ?>

       <h1 class="text-center">Edit Comment</h1>

       <div class="container">
             <form class="form-horizontal" action="?do=Update" method="POST">
                 <!-- user id Hidden -->
                  <input type="hidden" name="C_ID" value="<?php echo $C_ID ?>"/>

                  <!-- START USER NAME FIELD -->
                  <div class="form-group form-group-lg">
                   <label class="col-sm-2 control-label">Comment</label>
                   <div class="col-sm-10 col-md-4">
                      <textarea name="comment" class="form-control" rows="10" style="width:150%
"><?php echo $row['Comment']; ?></textarea>   
                   </div>
                   </div>


                  


                   <!-- START Submit FIELD -->
                  <div class="form-group form-group-lg">

                   <div class="col-sm-offset-2 col-sm-10">
                      <input type="Submit" value="Save" class="btn btn-success btn-lg" >
                   </div>
                   </div>
             </form>
       </div>


       <?php
 }
   else {
            echo "there's no such ID";

        }
}elseif($do == "Update"){ // updatepage

  echo "<h1 class ='text-center'> Welcome TO update page</h1>";
  echo "<div class ='container'>";

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

     //get variabls from FORM
    $id = $_POST['C_ID'];
    $comment = $_POST['comment'];
    
      $formErrors =  array();

     

      if (empty($comment)) {
        $formErrors = 'Comment  cant be empty ';
      
    
     echo '<div class="alert alert-danger"><b> '. $formErrors.'</b></div>';
    

// update database
      
    }else{

      $stmt = $con->prepare('UPDATE comments SET Comment = ? WHERE C_ID = ?');
      $stmt->execute(array($comment,$id));
       
       
        redirect('<div class="alert alert-success">Record updated</div>','back');

          }
      
  } else {

  echo "You CANT brows this page";
        }

  echo " </div>";
} elseif ($do=="delete") { // Delete Comment

  echo'<h1 class="text-center">Delete Comment</h1>';
	            $C_ID = isset($_GET['C_ID']) && is_numeric($_GET['C_ID']) ? intval($_GET['C_ID']) : 0 ;

       $stmt = $con->prepare("SELECT *
            FROM comments WHERE C_ID = ?
            LIMIT 1 ");


      $stmt->execute(array($C_ID));
      $row = $stmt->fetch();
      $count = $stmt->rowCount();


       if ($count>0) { 
        $stmt = $con->prepare("DELETE FROM comments WHERE C_ID = :C_ID ");
        $stmt->bindParam(':C_ID',$C_ID);
        $stmt->execute();    
        redirect('Record Deleted ','back',2);
     
     }else
     redirect('There IS No Such ID','back');


   }elseif ($do= 'activate') {
     $C_ID = isset($_GET['C_ID']) && is_numeric($_GET['C_ID']) ? intval($_GET['C_ID']) : 0 ;

       $stmt = $con->prepare("SELECT *
            FROM comments WHERE C_ID = ?
            LIMIT 1 ");


      $stmt->execute(array($C_ID));
      $row = $stmt->fetch();
      $count = $stmt->rowCount();


       if ($count>0) { 
        $stmt = $con->prepare("UPDATE  comments SET Status = 1 WHERE C_ID = ? ");
        
        $stmt->execute(array($C_ID));    
         
         redirect('Record updated ','back',1);
     
     }}
     else{
 	
    redirect('id not exist');
   
	






}
    //end
       include $tpl.'footer.php';

 	}
 	else{

 		header('Location: index.php');
 		exit();
 	}
