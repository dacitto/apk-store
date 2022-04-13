<?php
ob_start();
session_start();
 	$pageTitle = 'Apps';
 	if(isset($_SESSION['UserName'])){
 		//
       include 'init.php';

       //code begin
      $do = isset($_GET['do']) ? $_GET['do'] : 'manage' ;

if ($do == 'manage'){

	/*
$query='';  
	if (isset($_GET['page']) && $_GET['page']=='Approve'){
          $query ='WHERE Approve = 0';

       	$stmt2 = $con->prepare("SELECT * FROM items $query "); // select All Users with Admin too 

       	$stmt2->execute();

       	$rows2 = $stmt->fetchAll();

        }*/




	
       	$stmt = $con->prepare("SELECT items.* ,categories.Name AS Cat_Name , users.UserName AS User  FROM items 
INNER JOIN categories ON categories.ID = items.Cat_ID
INNER JOIN users ON users.UserID = items.Member_ID ORDER BY Item_ID DESC"); // select All Users with Admin too 

       	$stmt->execute();

       	$rows = $stmt->fetchAll();
       	?>

        <h1 class="text-center">Manage Apps</h1>;
        <div class ="container items">
        <a href="?do=add" class ="btn btn-success "><b>+</b> Upload New App</a>

        <div calss ="table-responsive">
        <table class="main-table table table-bordered text-center">
            	<tr>
              <td>#ID</td>
        	    <td>Image</td>
        	    <td>Application Name</td>
        	    <td>Description</td>
        	    <td>Price</td>
        	    <td>Upload Date</td>
        	    <td>Category</td>
        	    <td>UserName</td>
        	    <td>Control</td>
            	</tr>
         <?php 
                 foreach ($rows as $row) {
                 echo "<tr> ";
                 echo '<td>'.$row['Item_ID'].'</td>';
                 if (empty($row['Image'])) {
                 echo '<td><img src="uploads/images/prodect.png">';
                
                 }else{
                 echo '<td><img src="uploads/images/'.$row['Image'].'"></td>';
                 }
                 echo '<td>'.$row['Name']."</td>";
                 echo '<td>'.$row['Description'].'</td>';
                 echo '<td>'.$row['Price'].'</td>';
                 echo '<td>'.$row['Add_Date'].'</td>';
                 echo '<td>'.$row['Cat_Name'].'</td>';
                 echo '<td>'.$row['User'].'</td>';
                 echo '<td>
                 <a href="?do=edit&Item_ID='.$row['Item_ID'].'" class="btn btn-primary"><i class="fa fa-edit"></i> Edit</a>
                 <a href="?do=delete&Item_ID='.$row['Item_ID'].'" class="btn btn-danger confirm"><i class="fa fa-close"></i> Delete</a>';
                 if ($row['Approve']==0){
                 echo ' <a href="?do=Approve&Item_ID='.$row['Item_ID'].'" class="btn btn-info activate"> <i class="fa fa-exclamation"></i> Approve</a>';
                }
                 echo'</td>';

              echo "</tr>";  



              }

         ?>
        </table>
        </div>


       <a href="?do=add" class ="btn btn-success "><b>+ </b>Upload New App</a>
        </div>
       <?php 
       

      
}elseif ($do == 'add') {
	?>

        <h1 class="text-center">Add Item</h1>

        <div class="container">
              <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">


                   <!-- START  NAME FIELD -->
                   <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">App Name</label>
                    <div class="col-sm-10 col-md-6">
                       <input type="text" name="name" class="form-control" required  
                       placeholder="Name of Application" />
                    </div>
                    </div>

                    <!-- START  app FIELD -->
                   <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Apk</label>
                    <div class="col-sm-10 col-md-6">
                       <input type="file" name="app" class="form-control" required  
                       placeholder="path of App 'APK'" />
                    </div>
                    </div>

                    <!-- START  Description FIELD -->
                   <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10 col-md-6">
                       <input type="text" name="description" class="form-control" required 
                       placeholder="App Description" />
                    </div>
                    </div>

                     <!-- START  Price FIELD -->
                   <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Price</label>
                    <div class="col-sm-10 col-md-6">
                       <input type="text" name="price" class="form-control"  required

                       placeholder="Item price" value="0" />
                    </div>
                    </div>

                     <!-- START  developer of Made FIELD -->
                   <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Developer</label>
                    <div class="col-sm-10 col-md-6">
                       <input type="text" name="developer" class="form-control"  required
                       placeholder="Developer" />
                    </div>
                    </div>

                     <!-- START  Tags FIELD -->
                   <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Tags</label>
                    <div class="col-sm-10 col-md-6">
                       <input type="text" name="tags" class="form-control"  
                       placeholder="Tags" />
                    </div>
                    </div>

                     <!-- START  Category  FIELD -->
                   <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Category</label>
                    <div class="col-sm-10 col-md-6">
                      <select name="category" >
                      	<option value="">...</option>
                      	<?php 
                        
                        $cats =getTable('categories');
                        
                        foreach ($cats as $cat) {
                          if ($cat['Parent']==0){
                            
                        echo "<option value='".$cat['ID']."'>".$cat['Name']."</option>";
                            foreach (getTable('categories','Parent',$cat['ID']) as $subcat) {
                             echo "<option value='".$subcat['ID']."'>---".$subcat['Name']."</option>";
                                } 
                          }
                      }

                      	?>
                      
                      </select>
                    </div>
                    </div>

                    <!-- START  Member  FIELD -->
                   <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Member</label>
                    <div class="col-sm-10 col-md-6">
                      <select name="member" >
                      	<option value="">...</option>
                      	<?php 
                      	$stmt = $con->prepare("SELECT * FROM users");
                      	$stmt->execute();
                      	$users = $stmt->fetchAll();
                      	foreach ($users as $user) {
                      	echo "<option value='".$user['UserID']."'>".$user['UserName']."</option>";
                      	}

                      	?>
                      
                      </select>
                    </div>
                    </div>
                   
                    
                    
                    <!-- START image FIELD -->
                 <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Image</label>
                    <div class="col-sm-10 col-md-4">
                       <input type="file" name="image"  class="form-control" required="required" />
                    </div>
                    </div>



                   


                    <!-- START Submit FIELD -->
                   <div class="form-group form-group-lg">

                    <div class="col-sm-offset-2 col-sm-20">
                       <input type="Submit" value="Add Item" class="btn btn-success btn-lg" >
                    </div>
                    </div>
              </form>
        </div>
        <?php

}elseif ($do =='Insert') {
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          echo "<h1 class ='text-center'> Welcome TO insert Items page</h1>";
          echo "<div class ='container'>";


             //get variabls from FORM
           
            $name  		   = $_POST['name'];
            $description = $_POST['description'];
            $price 			 = $_POST['price'];
            $developer 		 = $_POST['developer'];
 
            $cat 		     = $_POST['category'];
            $member      = $_POST['member'];	
            
            $tags 	   = $_POST['tags'];
            
            $imageName = $_FILES['image']['name'];
            $imageSize = $_FILES['image']['size'];
            $imageTmp = $_FILES['image']['tmp_name'];
            $imageType = $_FILES['image']['type'];

            $appName = $_FILES['app']['name'];
            $appSize = $_FILES['app']['size'];
            $appTmp = $_FILES['app']['tmp_name'];
            $appType = $_FILES['app']['type'];

            $imageAllowedExtension = array('jpeg' ,'jpg' ,'png' ,'gif' );
            $appAllowedExtension =array('apk' );

            $imageExtension = strtolower(end(explode('.', $imageName)));
           
            $expload=explode('.', $appName);
            $end=end($expload);
            $appExtension = strtolower($end);
            
              $formErrors =  array();

              if (strlen($name)>250|| strlen($name)<1 || empty($name))  $formErrors[] = 'name lenght must be between 1 and 250 characters' ;

              if (empty($description)) {
                $formErrors[] = '  description  can\'t be empty ';}
              if (empty($price)) {
                $price = 0;}
       
              if ($cat === "") {
                $formErrors[] = ' you must choose a Category';}
              if ($member === "") {
                $formErrors[] = ' you must choose a Member';} 
            
                if (!in_array($imageExtension, $imageAllowedExtension)&&!empty($imageName)) {
                $formErrors[] = '  file Extension  isn\'t Allowed ';}
                 if (!in_array($appExtension, $appAllowedExtension)&&!empty($appName)) {
                $formErrors[] = '  file Extension  isn\'t Allowed  ';}

                  if ($imageSize>4194304) {
                                  $formErrors[] = '  file Size is more than 4Mb ';
                                }
            if (!empty($formErrors)) {
            
            foreach ($formErrors as$error  ) 
             echo '<div class="alert alert-danger"><b> '.$error .'</b></div>';
           //redirect('','back');
            
            }
            if (empty($formErrors)) {
            $image = rand(0,1000000).'_'.rand(0,1000000).'.'.$imageExtension;
          move_uploaded_file($imageTmp,"uploads/images/".$image);
           
            $app = rand(0,1000000).'_'.rand(0,1000000).'.'.$appExtension;
          move_uploaded_file($appTmp,"uploads/apps/".$app);
            
        // update database
             
       

              $stmt = $con->prepare("INSERT items (Name , App, Description, Price,Add_Date,developer_Made,Cat_ID,Image,Member_ID,Tags) 
              	                     VALUES ( :zname ,:zapp, :zdesc  , :zprice,now(),:zconutry,:zcat,:zimage,:zmember,:ztags)"); // or ( ?,..) or ($var ,..)
              $stmt->execute( array( 
               
               'zname' => $name,
               'zapp' => $app,
               'zdesc' => $description,
               'zprice'=> $price,
               'zconutry'=> $developer,
               'zcat'=> $cat,
               'ztags'=> $tags,
               'zimage'=> $image,
               'zmember'=> $member
           ));
                //echo success Message
              // $stmt->rowCount(); it doesnt Work and I dont know why !!
                
             //  redirect('<div class="alert alert-success">Record updated </div>','back',3);
              
        
          }
        } else {

          $error =  'You CANT brows this page';
         // redirect($error);
                }

          echo " </div>";


}elseif ($do == 'edit') {
	 $Item_ID = isset($_GET['Item_ID']) && is_numeric($_GET['Item_ID']) ? intval($_GET['Item_ID']) : 0 ;

       $stmt = $con->prepare("SELECT *
            FROM items WHERE Item_ID = ?
            LIMIT 1 ");


      $stmt->execute(array($Item_ID));
      $row = $stmt->fetch();
      $count = $stmt->rowCount();


      if ($count>0) {     ?>

       <h1 class="text-center">Edit Apps </h1>

       <div class="container">
            
              <form class="form-horizontal" action="?do=Update" method="POST" enctype="multipart/form-data">
                 <!-- Item id Hidden -->
                  <input type="hidden" name="Item_ID" value="<?php echo $Item_ID ?>"/>

         


                   <!-- START  NAME FIELD -->
                   <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Item Name</label>
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
                       <input type="text" name="price" class="form-control"  required   value="<?php echo $row['Price']; ?>"

                       placeholder="Item price" />
                    </div>
                    </div>

                     <!-- START  developer of Made FIELD -->
                   <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">developer</label>
                    <div class="col-sm-10 col-md-6">
                       <input type="text" name="developer" class="form-control"  required    value="<?php echo $row['developer_Made']; ?>"
                       placeholder="developer of Made" />
                    </div>
                    </div>

                     <!-- START  developer of Made FIELD -->
                   <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Tags</label>
                    <div class="col-sm-10 col-md-6">
                       <input type="text" name="tags" class="form-control"  required    value="<?php echo $row['Tags']; ?>"
                       placeholder="developer of Made" />
                    </div>
                    </div>


                     <!-- START  Category  FIELD -->
                   <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Category</label>
                    <div class="col-sm-10 col-md-6">
                      <select name="category" >
                      
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

                    <!-- START  Member  FIELD -->
                   <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Member</label>
                    <div class="col-sm-10 col-md-6">
                      <select name="member" >
                      	
                      	<?php 
                      	$stmt = $con->prepare("SELECT * FROM users");
                      	$stmt->execute();
                      	$users = $stmt->fetchAll();
                      	foreach ($users as $user) {
                      	echo "<option value='".$user['UserID']."'";
                      	if($row['Member_ID']==$user['UserID']) echo "selected";
                      	echo ">".$user['UserName']."</option>";
                      	}

                      	?>
                      
                      </select>
                    </div>
                    </div>
                     <!-- START  Status  FIELD -->
                   <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Status</label>
                    <div class="col-sm-10 col-md-6">
                      <select name="status" >
                      	<option value="1" <?php if($row['Status']==1) echo "selected"; ?>>New</option>
                      	<option value="2" <?php if($row['Status']==2) echo "selected"; ?>>Like New</option>
                      	<option value="3" <?php if($row['Status']==3) echo "selected"; ?>>Used</option>
                      
                      </select>
                    </div>
                    </div>


                     <!-- START Avatar FIELD -->
                 <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Image</label>
                    <div class="col-sm-10 col-md-6">
                       <input type="file" name="image"  class="form-control"  />
                    </div>
                  </div>



                    <!-- START Submit FIELD -->
                   <div class="form-group form-group-lg">

                    <div class="col-sm-offset-2 col-sm-10">
                       <input type="Submit" value="Save" class="btn btn-success btn-lg" >
                    </div>
                    </div>
              </form>
         <?php
              $stmt = $con->prepare("SELECT comments.*,users.UserName  FROM comments
                   
                   INNER JOIN
                   users
                   ON
                     users.UserID = comments.User_Id 
                     WHERE Item_Id = ?
          "); 

       	$stmt->execute(array($Item_ID));

       	$rows = $stmt->fetchAll();
       	if(!empty($rows)){

       	?>
        <h1 class="text-center"> Manage <?php echo $row['Name'] ;?> Comments </h1>;
        
        <div calss ="table-responsive">
        <table class="main-table table table-bordered text-center">
            	<tr>
        	    <td>#ID</td>
        	    <td>Comment</td>
              <td>Added Date</td>
              <td>User Name</td>
              
        	    <td>Control</td>
            	</tr>
         <?php 
                 foreach ($rows as $row2) {
                 echo "<tr> ";
                // if ($row2['Item_Id']==$row['Item_ID']) {  2nd Plain
                 
                 echo '<td>'.$row2['C_ID'].'</td>';
                 echo '<td>'.$row2['Comment']."</td>";
                 echo '<td>'.$row2['Comment_Date'].'</td>';
                 echo '<td>'.$row2['UserName'].'</td>';
                 
                 echo '<td><a href="?do=edit&C_ID='.$row2['C_ID'].'" class="btn btn-primary"><i class="fa fa-edit "></i> Edit</a>
                 <a href="comments.php?do=delete&C_ID='.$row2['C_ID'].'" class="btn btn-danger confirm"><i class="fa fa-close"></i> Delete</a>
                 ';
                if ($row2['Status']==0){
                  echo '<a href="?do=activate&C_ID='.$row2['C_ID'].'" class="btn btn-info activate"><i class="fa fa-exclamation"></i> Activate</a>';
                 }
                echo'</td>';
               // end of If Condition





            }  

              echo "</tr>";  



              
       	

         ?>
        </table>
        </div>
<?php  }// end of If !empty ?>
        </div> <!-- Container Div -->
      
        
      
        <?php
}
else 
    redirect('there is No such ID',"Back");
}elseif($do  == "Update"){
	echo "<h1 class ='text-center'> Welcome To Update Page</h1>";
  echo "<div class ='container'>";

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $Item_ID        = $_POST['Item_ID'];
            $name  		    = $_POST['name'];
            $description    = $_POST['description'];
            $price 			= $_POST['price'];
            $developer 		= $_POST['developer'];
           
            $cat 			= $_POST['category'];
            $member 		= $_POST['member'];	
            $tags 		= $_POST['tags'];
            
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
               $price= 0;}
   
              if ($cat === "") {
                $formErrors[] = ' you must choose a Category';}
              if ($member === "") {
                $formErrors[] = ' you must choose a Member';} 
                
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
              	,Member_ID = ? 
               WHERE Item_ID = ?');
               $stmt->execute( array( $name,
               	$description,
               	$price,
               	$developer,
               	
               	$tags,
               	$cat,
               	$member,
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
                ,Member_ID = ?
                ,Image = ?
               WHERE Item_ID = ?');
               $stmt->execute( array( $name,
                $description,
                $price,
                $developer,
                
                $rating,
                $cat,
                $member,
                $image,
                $Item_ID));
              }
              redirect('Record updated ','back',3);
        
          }} else {

          $error =  'You CANT brows this page';
          redirect($error);
                }

          echo " </div>";


}elseif ($do=="delete") {
	$Item_ID = isset($_GET['Item_ID']) && is_numeric($_GET['Item_ID']) ? intval($_GET['Item_ID']) : 0 ;

       $stmt = $con->prepare("SELECT *
            FROM items WHERE Item_ID = ?
            LIMIT 1 ");


      $stmt->execute(array($Item_ID));
      $row = $stmt->fetch();
      $count = $stmt->rowCount();


       if ($count>0) { 
        $stmt = $con->prepare("DELETE FROM items WHERE Item_ID = :Item_ID ");
        $stmt->bindParam(':Item_ID',$Item_ID);
        $stmt->execute();    
       // echo '<div class="alert alert-success">'.'Record updated '.'</div>';
         redirect('Record Deleted ','back',2);

     
     }
     else
     	redirect("there Is No Such Id",'back',2);



   


}elseif ($do= 'Approve') {
     $Item_ID = isset($_GET['Item_ID']) && is_numeric($_GET['Item_ID']) ? intval($_GET['Item_ID']) : 0 ;

       $stmt = $con->prepare("SELECT *
            FROM items WHERE Item_ID = ?
            LIMIT 1 ");


      $stmt->execute(array($Item_ID));
      $row = $stmt->fetch();
      $count = $stmt->rowCount();


       if ($count>0) { 
        $stmt = $con->prepare("UPDATE  items SET Approve = 1 WHERE Item_ID = ? ");
        
        $stmt->execute(array($Item_ID));    
         
         redirect('Record updated ');
     
     }
else
	redirect('There is No Such item_ID','back',1);


 }
    //end
       include $tpl.'footer.php';

 	}
 	else{

 		header('Location: index.php');
 		exit();}
 	
 	ob_end_flush();