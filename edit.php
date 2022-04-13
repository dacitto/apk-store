<?php

/*
 Add - edit - delete  members from here

 */

  session_start();
  $pageTitle = 'Members';
  if(isset($_SESSION['user'])){
    //
       include 'init.php';

       //code begin
       $do = isset($_GET['do']) ? $_GET['do'] : 'profile' ;

if ($do == 'profile'){         // 

  $userid = isset($_POST['userid']) && is_numeric($_POST['userid']) ? intval($_POST['userid']) : 0 ;

       $stmt = $con->prepare("SELECT *
            FROM users WHERE UserID = ?
            LIMIT 1 ");


      $stmt->execute(array($userid));
      $row = $stmt->fetch();
      $count = $stmt->rowCount();


      if ($count>0) {     ?>

       <h1 class="text-center">Edit Profile </h1>

       <div class="container">
        <div class="col-md-8">
          
             <form class="form-horizontal" action="?do=Update" method="POST" enctype="multipart/form-data">
                 <!-- user id Hidden -->
                  <input type="hidden" name="userid" value="<?php echo $userid ?>"/>

                  <!-- START USER NAME FIELD -->
                  <div class="form-group form-group-lg">
                   <label class="col-sm-2 control-label">Username</label>
                   <div class="col-sm-10 ">
                      <input type="text" name="username" class="form-control" value="<?php echo $row['UserName']; ?>" autocomplete="off" required = "required"/>
                   </div>
                   </div>


                   <!-- START PASSWORD FIELD -->
                  <div class="form-group form-group-lg">
                   <label class="col-sm-2 control-label">Password</label>
                   <div class="col-sm-10 ">
                      <input type="hidden" name="oldpassword" value="<?php echo $row['Password']; ?>" />
                      <input type="Password" name="newpassword" class="form-control" placeholder="leave it blank if you Dont change password" autocomplete="new-password"/>
                   </div>
                   </div>

                   <!-- START EMAIL FIELD -->
                  <div class="form-group form-group-lg">
                   <label class="col-sm-2 control-label">Email</label>
                   <div class="col-sm-10 ">
                      <input type="Email" name="email"  value="<?php echo $row['Email']?> " class="form-control" required = "required" />
                   </div>
                   </div>

                   <!-- START FullName FIELD -->
                  <div class="form-group form-group-lg">
                   <label class="col-sm-2 control-label">FullName</label>
                   <div class="col-sm-10 ">
                      <input type="text" name="fullname" value="<?php echo $row['FullName'] ?> "  class="form-control" required="required" />
                   </div>
                   </div>
                 <!-- START Avatar FIELD -->
                 <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Avatar</label>
                    <div class="col-sm-10 ">
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
        <div class="col-md-4 pull-right">
<?php 
if ($row['Avatar']=='')
	echo "<img class='img-responsive col-md-4' src='admin/uploads/user.png' alt='img'>";
else
echo "<img class='img-responsive col-md-4' src='admin/uploads/avatars/".$row['Avatar']."' alt='img'>";
 ?>
        </div>
       </div>


       <?php
     
 }
   else 
            echo "there's no such ID";




}elseif($do == "Update"){ // updatepage

  echo "<h1 class ='text-center'> Welcome To Update Members Page</h1>";
  echo "<div class ='container'>";
  echo $_FILES['avatar']['name'];

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
    $point='.';
            $avatarAllowedExtension = array('jpeg' ,'jpg' ,'png' ,'gif' );
            $tmp=explode('.' , $_FILES['avatar']['name']);
            $end=end($tmp);
            $avatarExtension = strtolower($end);
       

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
          move_uploaded_file($avatarTmp,"admin/uploads/avatars/".$avatar);
         unlink('admin/uploads/avatars/'.getAvatar($id));
      $stmt = $con->prepare('UPDATE users SET UserName = ?, Email=? ,FullName = ? ,Password = ? ,Avatar=? WHERE UserID = ?');
      $stmt->execute( array( $user,$email,$fullname,$password,$avatar,$id));    
        redirect('Record updated','back');
      
      }else{
        $stmt = $con->prepare('UPDATE users SET UserName = ?, Email=? ,FullName = ? ,Password = ?  WHERE UserID = ?');
      $stmt->execute( array( $user,$email,$fullname,$password,$id));    
        redirect('Record updated','back');
      
          }
      
  }} else {

  echo "You CANT brows this page";
        }

  echo " </div>";
}elseif ($do=="app"){ 
 
$Item_ID = isset($_POST['Item_ID']) && is_numeric($_POST['Item_ID']) ? intval($_POST['Item_ID']) : 0 ;

       $stmt = $con->prepare("SELECT *
            FROM items WHERE Item_ID = ?
            LIMIT 1 ");


      $stmt->execute(array($Item_ID));
      $row = $stmt->fetch();
      $count = $stmt->rowCount();


      if ($count>0) {     ?>

       <h1 class="text-center">Edit Items </h1>

       <div class="container">
            
              <form class="form-horizontal" action="?do=UpdateApp" method="POST" enctype="multipart/form-data">
                 <!-- Item id Hidden -->
                  <input type="hidden" name="Item_ID" value="<?php echo $Item_ID ?>"/>

         


                   <!-- START  NAME FIELD -->
                   <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">App Name</label>
                    <div class="col-sm-10 col-md-6">
                       <input type="text" name="name" class="form-control" required value="<?php echo $row['Name']; ?>" 
                       placeholder="Name of Item" />
                    </div>
                    </div>
                    <!-- START  Description FIELD -->
                   <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10 col-md-6">
                       <input type="text" name="description" class="form-control" required value="<?php echo $row['Description']; ?>"
                       placeholder="Item Description" />
                    </div>
                    </div>

                     <!-- START  Description FIELD -->
                   <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Price</label>
                    <div class="col-sm-10 col-md-6">
                       <input type="number" step="0.01" max="999" min="0" name="price" class="form-control"  required   value="<?php echo $row['Price']; ?>"

                       placeholder="App price" />
                    </div>
                    </div>

                     <!-- START  Country of Made FIELD -->
                   <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Devloper</label>
                    <div class="col-sm-10 col-md-6">
                       <input type="text" name="developer" class="form-control"  required    value="<?php echo $row['developer_Made']; ?>"
                       placeholder="Developer" />
                    </div>
                    </div>

                     <!-- START  Country of Made FIELD -->
                   <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Tags</label>
                    <div class="col-sm-10 col-md-6">
                       <input type="text" name="tags" class="form-control"  required    value="<?php echo $row['Tags']; ?>"
                       placeholder="Tags" />
                    </div>
                    </div>


                     <!-- START  Category  FIELD -->
                   <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Category</label>
                    <div class="col-sm-10 col-md-6">
                      <select name="category"  class="form-control">
                      
                        <?php 
                        $stmt2 = $con->prepare("SELECT * FROM categories");
                        $stmt2->execute();
                        $cats = $stmt2->fetchAll();
                        foreach ($cats as $cat) {
                        echo "<option value='".$cat['ID']."'";
                        if($row['Cat_ID']==$cat['ID'])
                         echo "selected";
                        echo ">".$cat['Name']."</option>";
                        }

                        ?>
                      
                      </select>
                    </div>
                    </div>

                  
                   
                     <!-- START image FIELD -->
                 <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Image</label>
                    <div class="col-sm-10 col-md-4">
                       <input type="file" name="image"  class="form-control"  />
                    </div>
                  </div>

                    <!-- START screenShot FIELD -->
                 <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Desc img1</label>
                    <div class="col-sm-10 col-md-4">
                       <input type="file" name="image1"  class="form-control"  />
                    </div>
                  </div>

                    <!-- START screenShot FIELD -->
                 <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Desc img2</label>
                    <div class="col-sm-10 col-md-4">
                       <input type="file" name="image2"  class="form-control"  />
                    </div>
                  </div>

                    <!-- START screenShot FIELD -->
                 <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Desc img3</label>
                    <div class="col-sm-10 col-md-4">
                       <input type="file" name="image3"  class="form-control"  />
                    </div>
                  </div>

                    <!-- START screenShot FIELD -->
                 <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Desc img4</label>
                    <div class="col-sm-10 col-md-4">
                       <input type="file" name="image4"  class="form-control"  />
                    </div>
                  </div>



                    <!-- START Submit FIELD -->
                   <div class="form-group form-group-lg">

                    <div class="col-sm-offset-2 col-sm-20">
                       <input type="Submit" value="Save" class="btn btn-success btn-lg" >
                    </div>
                    </div>
              </form> 
            <?php

} else {
  echo "there is no app";
}}
elseif ($do='UpdateApp'){
   echo "<h1 class ='text-center'> Welcome To Update Page</h1>";
  echo "<div class ='container'>";

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $Item_ID        = $_POST['Item_ID'];
            $name         = $_POST['name'];
            $description    = $_POST['description'];
            $price      = $_POST['price'];
            $developer    = $_POST['developer'];
            
            $cat      = $_POST['category'];
        
            $tags     = $_POST['tags'];
            
            if(!empty($_FILES['image']['name'])){

            $imageName = $_FILES['image']['name'];
            $imageSize = $_FILES['image']['size'];
            $imageTmp = $_FILES['image']['tmp_name'];
            $imageType = $_FILES['image']['type'];

            $imageAllowedExtension = array('jpeg' ,'jpg' ,'png' ,'gif' );

            $imageExtension = strtolower(end(explode('.', $imageName)));

    }






            
              $formErrors =  array();

              if (strlen($name)>250|| strlen($user)<1 || empty($name))  $formErrors[] = 'name lenght must be between 1 and 250 characters' ;

              if (empty($description)) {
                $formErrors[] = '  description  can\'t be empty ';}
              if (empty($price)) {
                $price = 0 ;}
             
              if ($cat === "") {
                $formErrors[] = ' you must choose a Category';}
     
             
             if(!empty($_FILES['image']['name'])){

               if (!in_array($imageExtension, $imageAllowedExtension)&&!empty($imageName)) {
                   $formErrors[] = '  file Extension  isn\'t Allowed ';}
               if ($imageSize>4194304) {
                     $formErrors[] = '  file Size is more than 4Mb ';
                   }}
               if (!empty($formErrors)) {
               
            foreach ($formErrors as$error  ) 
             echo '<div class="alert alert-danger"><b> '.$error .'</b></div>';
           redirect('','back');
            
            }
            if (empty($formErrors)) {
            
            if(empty($_FILES['image']['name'])){
        // update database
             
              $stmt = $con->prepare('UPDATE items 
                SET Name = ?
                ,Description=? 
                ,Price = ? 
                ,developer_Made = ? 
               
                ,Tags = ? 
                ,Cat_ID = ? 
              
               WHERE Item_ID = ?');
               $stmt->execute( array( $name,
                $description,
                $price,
                $developer,
              
                $tags,
                $cat,
              
                $Item_ID));

              
                
                redirect('Record updated ','back',3);
              }else{

                $image = rand(0,1000000).'_'.rand(0,1000000).'.'.$imageExtension;
                 move_uploaded_file($imageTmp,"uploads/images/".$image);

              $stmt = $con->prepare('UPDATE items 
                SET Name = ?
                ,Description=? 
                ,Price = ? 
                ,developer_Made = ? 
               
                ,Rating = ? 
                ,Cat_ID = ? 
                ,Tags = ?
                ,Image = ?
               WHERE Item_ID = ?');
               $stmt->execute( array( $name,
                $description,
                $price,
                $developer,
              
                $rating,
                $cat,
                $tags,
                $image,
                $Item_ID));
              }
              redirect('Record updated ','back',3);
        
          }} else {

          $error =  'You CANT brows this page';
          redirect($error);
                }

          echo " </div>";
}

      
  





}//end if is set Session