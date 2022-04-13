<?php

/*
 Add - edit - delete  members from here

 */

 	session_start();
 	$pageTitle = 'Members';
 	if(isset($_SESSION['UserName'])){
 		//
       include 'init.php';

       //code begin
       $do = isset($_GET['do']) ? $_GET['do'] : 'manage' ;

if ($do == 'manage'){         // 
        $query ='';
        if (isset($_GET['page']) && $_GET['page']=='Pending'){
          $query ='WHERE RegStatus = 0';
        }
       
       
        


       	$stmt = $con->prepare("SELECT * FROM users  $query ORDER BY UserID DESC "); // select All Users with Admin too 

       	$stmt->execute();

       	$rows = $stmt->fetchAll();
       	?>
        <h1 class="text-center">Manage Members</h1>;
        <div class ="container ">
        <div calss ="table-responsive">
        <table class="main-table  members table table-bordered text-center">
            	<tr>
              <td>#ID</td>
        	    <td>Avatar</td>
        	    <td>Username</td>
        	    <td>Email</td>
        	    <td>FullName</td>
        	    <td>Regiseter Date</td>
        	    <td>Control</td>
            	</tr>
         <?php 
                 foreach ($rows as $row) {
                 echo "<tr> ";
                 echo '<td>'.$row['UserID'].'</td>';
                 if (empty($row['Avatar'])) {
                 echo '<td><img src="uploads/user.png">';
                
                 }else{
                 echo '<td><img src="uploads/avatars/'.$row['Avatar'].'"></td>';
                 }
                 echo '<td>'.$row['UserName'];
                 if ($row['GroupID']==1)
                 	echo " <i>-Admin-</i>";
                 if ($row['RegStatus']==0)
                    echo "(Not Active)";    
                 echo "</td>";
                 echo '<td>'.$row['Email'].'</td>';
                 echo '<td>'.$row['FullName'].'</td>';
                 echo '<td>'.$row['Date'].'</td>';
                 echo '<td><a href="?do=edit&UserId='.$row['UserID'].'" class="btn btn-primary"><i class="fa fa-edit "></i> Edit</a>
                 <a href="?do=delete&UserId='.$row['UserID'].'" class="btn btn-danger confirm"><i class="fa fa-close"></i> Delete</a>
                 ';
                if ($row['RegStatus']==0){
                  echo '<a href="?do=activate&UserId='.$row['UserID'].'"; class="btn btn-info activate"><i class="fa fa-exclamation"></i> Activate</a>';
                }
                echo'</td>';

              echo "</tr>";  



              }

         ?>
        </table>
        </div>


       <a href="?do=add" class ="btn btn-success "><b>+<i class="fa fa-user"></i> </b>Add</a>
        </div>
       <?php 
       
      }elseif ($do == 'add') { // add members page
         ?>

        <h1 class="text-center">add Member </h1>

        <div class="container">
              <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">


                   <!-- START USER NAME FIELD -->
                   <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Username</label>
                    <div class="col-sm-10 col-md-4">
                       <input type="text" name="username" class="form-control"  required = "required"/>
                    </div>
                    </div>


                    <!-- START PASSWORD FIELD -->
                   <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10 col-md-4">

                       <input type="Password" name="password" class="password form-control" autocomplete="new-password" required="required"/>
                       <i class="show-pass fa fa-eye fa-2x"></i>
                    </div>
                    </div>

                    <!-- START EMAIL FIELD -->
                   <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10 col-md-4">
                       <input type="Email" name="email"  class="form-control" required = "required" />
                    </div>
                    </div>

                    <!-- START FullName FIELD -->
                   <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">FullName</label>
                    <div class="col-sm-10 col-md-4">
                       <input type="text" name="fullname"  class="form-control" required="required" />
                    </div>
                    </div>

                    <!-- START Avatar FIELD -->
                 <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Avatar</label>
                    <div class="col-sm-10 col-md-4">
                       <input type="file" name="avatar"  class="form-control" required="required" />
                    </div>
                    </div>


                    <!-- START Submit FIELD -->
                   <div class="form-group form-group-lg">

                    <div class="col-sm-offset-2 col-sm-10">
                       <input type="Submit" value="Add member" class="btn btn-success btn-lg" >
                    </div>
                    </div>
              </form>
        </div>
        <?php
        }
        elseif ($do =='Insert') {
          if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          echo "<h1 class ='text-center'> Welcome TO insert page page</h1>";
          echo "<div class ='container'>";


             //get variabls from FORM
           
            $user     = $_POST['username'];
            $email    = $_POST['email'];
            $fullname = $_POST['fullname'];
            $password = $_POST['password'];
            $hashpass =  sha1( $_POST['password'] ) ;
            
            $avatarName = $_FILES['avatar']['name'];
            $avatarSize = $_FILES['avatar']['size'];
            $avatarTmp = $_FILES['avatar']['tmp_name'];
            $avatarType = $_FILES['avatar']['type'];

            $avatarAllowedExtension = array('jpeg' ,'jpg' ,'png' ,'gif' );

            $avatarExtension = strtolower(end(explode('.', $avatarName)));

            
              $formErrors =  array();

              if (strlen($user)>20 || strlen($user)<4 || empty($user))  $formErrors[] = 'username lenght must be between 4 and 25 characters' ;

              if (empty($fullname)) {
                $formErrors[] = '  fullname  can\'t be empty ';}
              if (empty($email)) {
                $formErrors[] = ' email can\'t be empty';}
              if (empty($password)) {
                $formErrors[] = ' password can\'t be empty';}
              if (!in_array($avatarExtension, $avatarAllowedExtension)&&!empty($avatarName)) {
                $formErrors[] = '  file Extension  isn\'t Allowed ';
              }
                  if ($avatarSize>4194304) {
                                  $formErrors[] = '  file Size is more than 4Mb ';
                                }

            foreach ($formErrors as$error  ) {
             echo '<div class="alert alert-danger"><b> '.$error .'</b></div>';
             redirect('','back',2);
            }
        // update database
              if (empty($formErrors)) {
              	 if(checkItem("UserName","users",$user)>0){
        
        	redirect("sorry the user is exist",'back',3);
        }
        else {  

          $avatar = rand(0,1000000).'_'.rand(0,1000000).'.'.$avatarExtension;
          move_uploaded_file($avatarTmp,"uploads/avatars/".$avatar);
       

              $stmt = $con->prepare("INSERT users (UserName, Password, Email, FullName,RegStatus,Date,Avatar) 
              	                     VALUES ( :zuser , :zpass  , :zemail,:zfull,1,now(),:zavatar)"); // or ( ?,..) or ($var ,..)
              $stmt->execute( array( 
               'zuser' => $user,
               'zpass' => $hashpass,
               'zemail'=> $email,
               'zavatar'=> $image,
               'zfull' => $fullname ));
                //echo success Message
              // $stmt->rowCount(); it doesnt Work and I dont know why !!
                
                redirect('<div class="alert alert-success">Record updated </div>','something else',3);
                
              }
        }
          } else {

          $error =  "You CANT brows this page";
          redirect($error,3);
                }

          echo " </div>";
        }
        



       elseif ($do == 'edit') { //edit page
            $userid = isset($_GET['UserId']) && is_numeric($_GET['UserId']) ? intval($_GET['UserId']) : 0 ;

       $stmt = $con->prepare("SELECT *
            FROM users WHERE UserID = ?
            LIMIT 1 ");


      $stmt->execute(array($userid));
      $row = $stmt->fetch();
      $count = $stmt->rowCount();


      if ($count>0) {     ?>

       <h1 class="text-center">Edit Members </h1>

       <div class="container">
             <form class="form-horizontal" action="?do=Update" method="POST" enctype="multipart/form-data">
                 <!-- user id Hidden -->
                  <input type="hidden" name="userid" value="<?php echo $userid ?>"/>

                  <!-- START USER NAME FIELD -->
                  <div class="form-group form-group-lg">
                   <label class="col-sm-2 control-label">Username</label>
                   <div class="col-sm-10 col-md-4">
                      <input type="text" name="username" class="form-control" value="<?php echo $row['UserName']; ?>" autocomplete="off" required = "required"/>
                   </div>
                   </div>


                   <!-- START PASSWORD FIELD -->
                  <div class="form-group form-group-lg">
                   <label class="col-sm-2 control-label">Password</label>
                   <div class="col-sm-10 col-md-4">
                      <input type="hidden" name="oldpassword" value="<?php echo $row['Password']; ?>" />
                      <input type="Password" name="newpassword" class="form-control" placeholder="leave it blank if you Dont change password" autocomplete="new-password"/>
                   </div>
                   </div>

                   <!-- START EMAIL FIELD -->
                  <div class="form-group form-group-lg">
                   <label class="col-sm-2 control-label">Email</label>
                   <div class="col-sm-10 col-md-4">
                      <input type="Email" name="email"  value="<?php echo $row['Email']?> " class="form-control" required = "required" />
                   </div>
                   </div>

                   <!-- START FullName FIELD -->
                  <div class="form-group form-group-lg">
                   <label class="col-sm-2 control-label">FullName</label>
                   <div class="col-sm-10 col-md-4">
                      <input type="text" name="fullname" value="<?php echo $row['FullName'] ?> "  class="form-control" required="required" />
                   </div>
                   </div>
                 <!-- START Avatar FIELD -->
                 <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Avatar</label>
                    <div class="col-sm-10 col-md-4">
                       <input type="file" name="avatar"  class="form-control"  />
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

  echo "<h1 class ='text-center'> Welcome To Update Members Page</h1>";
  echo "<div class ='container'>";
  

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

     //get variabls from FORM
    $id = $_POST['userid'];
    $user = $_POST['username'];
    $email = $_POST['email'];
    $fullname = $_POST['fullname'];
    $password = '';
    if(!empty($_FILES['avatar']['name'])){

    $avatarName = $_FILES['avatar']['name'];
    $avatarSize = $_FILES['avatar']['size'];
    $avatarTmp = $_FILES['avatar']['tmp_name'];
    $avatarType = $_FILES['avatar']['type'];

            $avatarAllowedExtension = array('jpeg' ,'jpg' ,'png' ,'gif' );

            $avatarExtension = strtolower(end(explode('.', $avatarName)));

    }

    //passWord

      $password = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1( $_POST['newpassword'] ) ;

      $formErrors =  array();
if(!empty($_FILES['avatar']['name'])){

      if (!in_array($avatarExtension, $avatarAllowedExtension)&&!empty($avatarName)) {
                $formErrors[] = '  file Extension  isn\'t Allowed ';}
      if ($avatarSize>4194304) {
                                  $formErrors[] = '  file Size is more than 4Mb '; }
}


      if (strlen($user)>25 || strlen($user)<4 || empty($user))  
        $formErrors[] = 'username lenght must be between 4 and 25 characters' ;

      if (empty($fullname)) {
        $formErrors[] = '  fullname  cant be empty ';}
      if (empty($email)) {
        $formErrors[] = ' email cant be empty';}

    foreach ($formErrors as$error  ) {
     echo '<div class="alert alert-danger"><b> '.$error .'</b></div>';
    }
// update database
      if (empty($formErrors)) {
        $stmt=$con->prepare('SELECT * FROM users WHERE UserName=? AND UserID!=?');
        $stmt->execute(array($user,$id));
        $count=$stmt->rowCount();

      }

      	if ($count >0){

        redirect("UserName is exist",'back');
    }else{
   if(!empty($_FILES['avatar']['name'])){
      $avatar = rand(0,1000000).'_'.rand(0,1000000).'.'.$avatarExtension;
          move_uploaded_file($avatarTmp,"uploads/avatars/".$avatar);

      $stmt = $con->prepare('UPDATE users SET UserName = ?, Email=? ,FullName = ? ,Password = ? ,Avatar=? WHERE UserID = ?');
      $stmt->execute( array( $user,$email,$fullname,$password,$avatar,$id));    
        redirect('Record updated','back');
      
      }else{
        $stmt = $con->prepare('UPDATE users SET UserName = ?, Email=? ,FullName = ? ,Password = ?  WHERE UserID = ?');
      $stmt->execute( array( $user,$email,$fullname,$password,$id));    
        redirect('Record updated','back');
      
          }
      
  } }else {

  echo "You CANT brows this page";
        }

  echo " </div>";
} elseif ($do=="delete") { // Delete Members
	            $userid = isset($_GET['UserId']) && is_numeric($_GET['UserId']) ? intval($_GET['UserId']) : 0 ;

       $stmt = $con->prepare("SELECT *
            FROM users WHERE UserID = ?
            LIMIT 1 ");


      $stmt->execute(array($userid));
      $row = $stmt->fetch();
      $count = $stmt->rowCount();


       if ($count>0) { 
        $stmt = $con->prepare("DELETE FROM users WHERE UserID = :userid ");
        $stmt->bindParam(':userid',$userid);
        $stmt->execute();    
         
         redirect('Record Deleted ','back');
     
     }
     else
      redirect('There Is No Such ID','back');


   }elseif ($do= 'activate') {
     $userid = isset($_GET['UserId']) && is_numeric($_GET['UserId']) ? intval($_GET['UserId']) : 0 ;

       $stmt = $con->prepare("SELECT *
            FROM users WHERE UserID = ?
            LIMIT 1 ");


      $stmt->execute(array($userid));
      $row = $stmt->fetch();
      $count = $stmt->rowCount();


       if ($count>0) { 
        $stmt = $con->prepare("UPDATE  users SET RegStatus = 1 WHERE UserID = ? ");
        
        $stmt->execute(array($userid));    
         
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
