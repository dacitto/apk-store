<?php


/*
==========================================
Category page 
==========================================
*/

ob_start();
session_start();
 	$pageTitle = 'Categories';
 	if(isset($_SESSION['UserName'])){
 		//
       include 'init.php';

       //code begin
      $do = isset($_GET['do']) ? $_GET['do'] : 'manage' ;

if ($do == 'manage'){  

	$sort='ASC';
	$sort_array= array('ASC', 'DESC');
	if (isset($_GET['sort'])&& in_array($_GET['sort'], $sort_array)) {
		$sort = $_GET['sort'];
	}

	$stmt2 = $con->prepare("SELECT * FROM categories ORDER BY Ordering $sort");
	$stmt2->execute();
	$cats = $stmt2->fetchAll(); 
	// html ======================================= 
	?>   
<h1 class="text-center"> Manage Categories</h1>
<div class="container categories">
				<div class="add-button">	
				<a href="?do=add"  class="btn btn-primary add-button">+Add New Category</a>
				</div>
	<div class="panel panel-default">
		<div class="panel-heading">Manage Category
			
        <div class="ordering pull-right">
        	<i class="fa fa-sort"></i> Ordering:
        	<a href="categories.php?sort=ASC"  class='option<?php  if ($sort=="ASC") {echo" active";}?>' >ASC</a>
        	<a href="categories.php?sort=DESC" class='option<?php  if ($sort=="DESC"){echo" active";}?> '>DESC</a>
        	 <i class="fa fa-eye"></i> View:
        	 <span class='option active' data-view='full'>Full</span> 
			 <span class='option' data-view='lite'>Lite</span>
        </div>

		</div>
		<div class="panel-body">
			<?php 
			foreach ($cats as $cat) {
        if ($cat['Parent']==0) {
          
        echo "<div class='cat'>";
        echo "<div class='hidden-buttons'>";
          echo "<a href='categories.php?do=edit&catid=".$cat['ID']."' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i>Edit</a> ";
          echo "<a href='categories.php?do=delete&catid=".$cat['ID']."' class='btn btn-xs btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";
          

        echo "</div>";
        echo "<h3>".$cat['Name']."</h3>";
          echo "<div class='full-view'>";
          $subCat=getTable('categories','Parent',$cat['ID']);

              if ($cat['Description'] !== "")
              echo "<span class='description'>".$cat['Description']."</span>"."<br/>";
                else
              echo "<span class='description'>"."This Category has No Description </span>"."<br/>";
               if (!empty($subCat)) {
                echo "<div class='row'>";
                 echo '<span class="col-md-2">Sub-Categories :</span>';
                  echo "<ul class='list-unstyled'>";
             foreach($subCat as $sub){
              
              echo "<li><a href='categories.php?do=edit&catid=".$sub['ID']."' class='black'> ".$sub['Name'].'</a></li>';
             }
             echo "</ul>";
             echo "</div>";
               }
              echo "<span class='ordering'>"."Ordering ".$cat['Ordering']."</span>";
              if ($cat['Visibility']==1) echo "<span class='visibility'><i class='fa fa-eye'></i> Hidden</span>";
              if ($cat['Allow_Comments']==1) echo "<span class='commenting'><i class='fa fa-close'></i> No Comments</span>";
              if ($cat['Allow_Ads']==1)echo "<span class='ads'><i class='fa fa-ban'></i> No ads</span>";
          echo "</div>";
      echo "</div> <hr>";

      }

        }
      ?>
    </div>
  </div>
</div>
    
   




<?php
}elseif ($do == 'add') {

  ?>

        <h1 class="text-center">Add Category </h1>

        <div class="container">
              <form class="form-horizontal" action="?do=Insert" method="POST">


                   <!-- START  NAME FIELD -->
                   <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Category Name</label>
                    <div class="col-sm-10 col-md-4">
                       <input type="text" name="name" class="form-control"  required = "required" autocomplete="off" 
                       placeholder="Name of Category" />

                    </div>
                    </div>


                    <!-- START Description FIELD -->
                   <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Descrition</label>
                    <div class="col-sm-10 col-md-4">

                       <input type="text" name="description" class="form-control"  placeholder="Description" />
                       
                    </div>
                    </div>

                    <!-- START Ordering FIELD -->
                   <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Ordering</label>
                    <div class="col-sm-10 col-md-4">
                       <input type="text" name="ordering"  class="form-control" placeholder="To arrange the Category" />
                    </div>
                    </div>

                    <!-- START Parent FIELD -->
                   <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Parent Category</label>
                    <div class="col-sm-10 col-md-4">

                      <?php 
                             $cat= getTable('categories','Parent',0);
                             echo " <select name='parent' > ";
                             echo "<option value='0'>None</option>";
                             foreach ($cat as $cat) {
                              echo "<option value='".$cat['ID']."' >".$cat['Name']."</option>";
                             }
                             echo '</select>';

                      ?>

                    </div>
                    </div>
                    

                    <!-- START Visibility FIELD -->
                   <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Visible</label>
                    <div class="col-sm-10 col-md-4">
                       <div>
                       	<input type="radio" id="visibility-yes" name="visibility" value="0" checked>
                       	<label for="visibility-yes">Yes</label>
                       </div>
                       <div>
                       	<input type="radio" id="visibility-no" name="visibility" value="1" >
                       	<label for="visibility-no">No</label>
                       </div>
                    </div>
                    </div>

                    <!-- START Commenting FIELD -->
                   <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Allow Commenting</label>
                    <div class="col-sm-10 col-md-4">
                       <div>
                       	<input type="radio" id="commenting-yes" name="commenting" value="0" checked>
                       	<label for="commenting-yes">Yes</label>
                       </div>
                       <div>
                       	<input type="radio" id="commenting-no" name="commenting" value="1" >
                       	<label for="commenting-no">No</label>
                       </div>
                    </div>
                    </div>

                    <!-- START Ads FIELD -->
                   <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Allow Ads</label>
                    <div class="col-sm-10 col-md-4">
                       <div>
                       	<input type="radio" id="ads-yes" name="ads" value="0" checked>
                       	<label for="ads-yes">Yes</label>
                       </div>
                       <div>
                       	<input type="radio" id="ads-no" name="ads" value="1" >
                       	<label for="ads-no">No</label>
                       </div>
                    </div>
                    </div>


                    <!-- START Submit FIELD -->
                   <div class="form-group form-group-lg">

                    <div class="col-sm-offset-2 col-sm-10">
                       <input type="Submit" value="Add Category" class="btn btn-success btn-lg" >
                    </div>
                    </div>
              </form>
        </div>
        <?php



}elseif ($do =='Insert') {
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          echo "<h1 class ='text-center'> Welcome To Insert Category Page</h1>";
          echo "<div class ='container'>";


             //get variabls from FORM
           
            $name      	= $_POST['name'];
            $description= $_POST['description'];
            $ordering 	= $_POST['ordering'];
            $visibility = $_POST['visibility'];
            $commenting = $_POST['commenting'];
            $parent     = $_POST['parent']; 
            $ads 		    = $_POST['ads'];
            
              

              

              

           
        // update database
              
              	if(checkItem("Name","categories",$name)>0){
        
        	redirect("sorry the Category is exist",'back',3);
        }else {  

        	// Insert Category Inforamtions
       

              $stmt = $con->prepare("INSERT INTO categories (Name, Description, Ordering ,Visibility ,Allow_Comments, Allow_Ads,Parent) 
              	                     VALUES ( :zname , :zdesc  , :zorder,:zvisible ,:zcomments ,:zads,:zparent)"); // or ( ?,..) or ($var ,..)
              $stmt->execute( array( 
               'zname' 	 => $name,
               'zdesc'	 => $description,
               'zorder'	 => $ordering,
               'zvisible'=> $visibility,
               'zparent'=> $parent,
               'zcomments'=> $commenting,
               'zads'	 => $ads)
          );
                //echo success Message
              // $stmt->rowCount(); it doesnt Work and I dont know why !!
                
                redirect('<div class="alert alert-success">Record updated </div>',3);
              }
        
          } else {

          $error =  "You CANT brows this page";
          redirect($error,3);
                }

          echo " </div>";
        
        
}elseif ($do == 'edit') {
	$catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0 ;

       $stmt = $con->prepare("SELECT *
            FROM categories WHERE ID = ?
            ");


      $stmt->execute(array($catid));
      $cat = $stmt->fetch();
      $count = $stmt->rowCount();


      if ($count>0) {     ?>

       <h1 class="text-center">Edit Categories </h1>
       <div class="container">
              <form class="form-horizontal" action="?do=update" method="POST">


                   <!-- START  NAME FIELD -->
                   <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Category Name</label>
                    <div class="col-sm-10 col-md-4">
                       <input type="text" name="name" class="form-control"  required = "required" placeholder="Name of Category" value="<?php echo $cat['Name'];?>" />
                       <input type="hidden" name="catid" value="<?php echo $catid ?>"/>

                    </div>
                    </div>


                    <!-- START Description FIELD -->
                   <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Descrition</label>
                    <div class="col-sm-10 col-md-4">

                       <input type="text" name="description" class="form-control"  placeholder="Description" value="<?php echo $cat['Description'];?>"/>
                       
                    </div>
                    </div>

                    <!-- START Ordering FIELD -->
                   <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Ordering</label>
                    <div class="col-sm-10 col-md-4">
                       <input type="text" name="ordering"  class="form-control" placeholder="To arrange the Category" value="<?php echo $cat['Ordering'];?>"/>
                    </div>
                    </div>
                     <!-- START Parent FIELD -->
                   <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Parent Category</label>
                    <div class="col-sm-10 col-md-4">
                      <?php 
                             $cats2= getTable('categories','Parent',0);
                             echo " <select name='parent' > ";
                             echo "<option value='0'>None</option>";
                             foreach ($cats2 as $cat2) {
                              echo "<option value='".$cat2['ID']."'";
                              if ($cat['Parent']==$cat2['ID']) 
                                echo " selected";
                              echo " >".$cat2['Name']."</option>";
                             }
                             echo '</select>';

                      ?>
                       
                    </div>
                    </div>
                    <!-- START Visibility FIELD -->
                   <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Visible</label>
                    <div class="col-sm-10 col-md-4">
                       <div>
                       	<input type="radio" id="visibility-yes" name="visibility" value="0" <?php if ($cat['Visibility']==0)echo "checked"; ?>>
                       	<label for="visibility-yes">Yes</label>
                       </div>
                       <div>
                       	<input type="radio" id="visibility-no" name="visibility" value="1"  <?php if ($cat['Visibility']==1)echo "checked"; ?>>
                       	<label for="visibility-no">No</label>
                       </div>
                    </div>
                    </div>

                    <!-- START Commenting FIELD -->
                   <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Allow Commenting</label>
                    <div class="col-sm-10 col-md-4">
                       <div>
                       	<input type="radio" id="commenting-yes" name="commenting" value="0" <?php if ($cat['Allow_Comments']==0)echo "checked"; ?>>
                       	<label for="commenting-yes">Yes</label>
                       </div>
                       <div>
                       	<input type="radio" id="commenting-no" name="commenting" value="1"  <?php if ($cat['Allow_Comments']==1)echo "checked"; ?>>
                       	<label for="commenting-no">No</label>
                       </div>
                    </div>
                    </div>

                    <!-- START Ads FIELD -->
                   <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Allow Ads</label>
                    <div class="col-sm-10 col-md-4">
                       <div>
                       	<input type="radio" id="ads-yes" name="ads" value="0" <?php if ($cat['Allow_Ads']==0)echo "checked"; ?>>
                       	<label for="ads-yes">Yes</label>
                       </div>
                       <div>
                       	<input type="radio" id="ads-no" name="ads" value="1" <?php if ($cat['Allow_Ads']==1)echo "checked"; ?>>
                       	<label for="ads-no">No</label>
                       </div>
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
            
   	redirect("there's no such ID",1);

        }

}elseif($do == "update"){
	echo "<h1 class='text-center'>Categories Update Page</h1>";
	echo "<div class='container'>";
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
		$id         = $_POST['catid'];
		$name      	= $_POST['name'];
        $description= $_POST['description'];
        $ordering 	= $_POST['ordering'];
        $visibility = $_POST['visibility'];
        $commenting = $_POST['commenting'];
        $parent     = $_POST['parent']; 
        $ads 		= $_POST['ads'];

        if ($name == '') {
        	redirect('Category Name Is empty Update FIELD');
        }else{
        	$stmt = $con->prepare('UPDATE categories SET Name = ?, Description=? ,Ordering = ? ,Visibility = ?,Allow_Comments = ? ,Allow_Ads = ?, Parent=? WHERE ID = ?');
      $stmt->execute( array( $name,$description,$ordering,$visibility,$commenting,$ads,$parent,$id));
        //echo success Message
      // $stmt->rowCount(); it doesnt Work and I dont know why !!
       
        redirect('<div class="alert alert-success">Record updated</div>','back');


        }

	}else {

  echo "You CANT brows this page";
        }

  echo " </div>";

}elseif ($do=="delete") {
  $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0 ;

       $stmt = $con->prepare("SELECT *
            FROM categories WHERE ID = ?
            LIMIT 1 ");


      $stmt->execute(array($catid));
      $row = $stmt->fetch();
      $count = $stmt->rowCount();


       if ($count>0) { 
        $stmt = $con->prepare("DELETE FROM categories WHERE ID = :catid ");
        $stmt->bindParam(':catid',$catid);
        $stmt->execute();    
         $mes= '<div class="alert alert-success">Record updated </div>';

         redirect($mes,3);
     
     }

   
}else{
header('Location: dashboard.php');
 		exit();}

    //end
       include $tpl.'footer.php';

 	}
 	else{

 		header('Location: index.php');
 		exit();}
 	
 	ob_end_flush();