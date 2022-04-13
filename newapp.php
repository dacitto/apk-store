<?php
ob_start();
    session_start();
    $pageTitle="Creat New ad";
    include "init.php"; 
    if (isset($_SESSION['user'])) {
    $userInfo = $con->prepare('SELECT * FROM users WHERE UserName = ?');
    $userInfo->execute(array($sessionUser));
    $info = $userInfo->fetch();

    
     if ($_SERVER['REQUEST_METHOD']=='POST') {
            $name        = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
            $description = filter_var($_POST['description'],FILTER_SANITIZE_STRING);
            $name        = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
            $description = filter_var($_POST['description'],FILTER_SANITIZE_STRING);
            $price       = filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_INT);
            $developer     = filter_var($_POST['developer'],FILTER_SANITIZE_STRING);
            
            $cat         = filter_var($_POST['category'],FILTER_SANITIZE_STRING);
            $tags         = filter_var($_POST['tags'],FILTER_SANITIZE_STRING);

            $member_Id   = $info['UserID'];
           
            $imageName = $_FILES['image']['name'];
            $imageSize = $_FILES['image']['size'];
            $imageTmp = $_FILES['image']['tmp_name'];
            $imageType = $_FILES['image']['type'];

            $imageName1 = $_FILES['image1']['name'];
            $imageSize1 = $_FILES['image1']['size'];
            $imageTmp1 = $_FILES['image1']['tmp_name'];
            $imageType1 = $_FILES['image1']['type'];

            $imageName2 = $_FILES['image2']['name'];
            $imageSize2 = $_FILES['image2']['size'];
            $imageTmp2 = $_FILES['image2']['tmp_name'];
            $imageType2 = $_FILES['image2']['type'];

            $imageName3 = $_FILES['image3']['name'];
            $imageSize3 = $_FILES['image3']['size'];
            $imageTmp3 = $_FILES['image3']['tmp_name'];
            $imageType3 = $_FILES['image3']['type'];

            $imageName4 = $_FILES['image4']['name'];
            $imageSize4 = $_FILES['image4']['size'];
            $imageTmp4 = $_FILES['image4']['tmp_name'];
            $imageType4 = $_FILES['image4']['type'];



            $imageAllowedExtension = array('jpeg' ,'jpg' ,'png' ,'gif' );
            
            $exploid=explode('.', $_FILES['image']['name']);
            $end=end($exploid);
            $imageExtension = strtolower($end);
            
            $exploid1=explode('.', $_FILES['image1']['name']);
            $end1=end($exploid1);
            $imageExtension1 = strtolower($end1);
            
            $exploid2=explode('.', $_FILES['image2']['name']);
            $end2=end($exploid2);
            $imageExtension2 = strtolower($end2);
            
            $exploid3=explode('.', $_FILES['image3']['name']);
            $end3=end($exploid3);
            $imageExtension3 = strtolower($end3);
            
            $exploid4=explode('.', $_FILES['image4']['name']);
            $end4=end($exploid4);
            $imageExtension4 = strtolower($end4);


            $appName = $_FILES['app']['name'];
            $appSize = $_FILES['app']['size'];
            $appTmp = $_FILES['app']['tmp_name'];
            $appType = $_FILES['app']['type'];
            $appAllowedExtension =array('apk' );

            $expload=explode('.', $appName);
            $end=end($expload);
            $appExtension = strtolower($end);
            
              
             














              $formErrors =  array();

              if (strlen($name)>250|| strlen($name)<1 || empty($name))  $formErrors[] = 'name lenght must be between 1 and 250 characters' ;

              if (empty($description)) {
                $formErrors[] = '  description  can\'t be empty ';}
              if (empty($price)) {
                $price = 0;
                }
                if (empty($developer)) {
                $formErrors[] = ' developer can\'t be empty';}
              
              if ($cat === "") {
                $formErrors[] = ' you must choose a Category';}
              
            
               if (!in_array($imageExtension, $imageAllowedExtension)&&!empty($imageName)) {
             $formErrors[] = '  file Extension  isn\'t Allowed ';}
               if ($imageSize>4194304) {
                            $formErrors[] = '  file Size must be less than 4Mb ';
                                }

            if (empty($formErrors)) {


              $image = rand(0,1000000).'_'.rand(0,1000000).rand(0,1000000).'.'.$imageExtension;
              move_uploaded_file($imageTmp,"admin/uploads/images/".$image);

              $image1 = rand(0,1000000).'_'.rand(0,1000000).rand(0,1000000).'.'.$imageExtension1;
              move_uploaded_file($imageTmp1,"admin/uploads/DescImages/".$image1);

              $image2 = rand(0,1000000).'_'.rand(0,1000000).rand(0,1000000).'.'.$imageExtension2;
              move_uploaded_file($imageTmp2,"admin/uploads/DescImages/".$image2);

              $image3 = rand(0,1000000).'_'.rand(0,1000000).rand(0,1000000).'.'.$imageExtension3;
              move_uploaded_file($imageTmp3,"admin/uploads/DescImages/".$image3);

              $image4 = rand(0,1000000).'_'.rand(0,109500).'.'.$imageExtension4;
              move_uploaded_file($imageTmp4,"admin/uploads/DescImages/".$image4);

           

               $app = rand(0,1000000).'_'.rand(0,1000000).'.'.$appExtension;
                    move_uploaded_file($appTmp,"admin/uploads/apps/".$app);
                      
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
               'zmember'=> $_SESSION['theUserID']
             
           ));
              
              $lastID = $con->lastInsertId() ;

               
              $stmt1 = $con->prepare("INSERT images (Image,Item_Id) 
                                     VALUES ( :image , :itemid  )"); 
              $stmt1->execute( array('image' => $image1,'itemid' => $lastID ));

              $stmt2 = $con->prepare("INSERT images (Image,Item_Id) 
                                     VALUES ( :image , :itemid  )"); 
              $stmt2->execute( array('image' => $image2,'itemid' => $lastID ));

              $stmt3 = $con->prepare("INSERT images (Image,Item_Id) 
                                     VALUES ( :image , :itemid  )"); 
              $stmt3->execute( array('image' => $image3,'itemid' => $lastID ));

              $stmt4 = $con->prepare("INSERT images (Image,Item_Id) 
                                     VALUES ( :image , :itemid  )"); 
              $stmt4->execute( array('image' => $image4,'itemid' => $lastID ));

              





              if ($stmt) {
                  
                      redirect('<div class="alert alert-success">item added </div>','back',3);
              }
            }
     }
    ?>
  
   
<h1 class="text-center">Upload New App</h1>

<div class="information">
	<div class="container">
		<div class="panel panel-primary ">
			<div class="panel-heading">
			Upload New App
            </div>
            <div class="panel-body">
				<div class="row">
                <div class="col-md-8">
                  
                    <form class="form-horizontal main-form" action="<?php echo$_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data">


                   <!-- START  NAME FIELD -->
                   <div class="form-group form-group-lg">
                    <label class="col-sm-3 control-label">App Name</label>
                    <div class="col-sm-9 col-md-9">
                       <input type="text" name="name" class="form-control live" required  
                       data-class=".live-name"
                       placeholder="Name of Application" 
                       pattern=".{3,}" />
                    </div>
                    </div>

                     <!-- START  app FIELD -->
                   <div class="form-group form-group-lg">
                    <label class="col-sm-3 control-label">Apk</label>
                    <div class="col-sm-9 col-md-9">
                       <input type="file" name="app" class="form-control" required  
                       placeholder="path of App 'APK'" />
                    </div>
                    </div>


                    <!-- START  Description FIELD -->
                   <div class="form-group form-group-lg">
                    <label class="col-sm-3 control-label">Description</label>
                    <div class="col-sm-9 col-md-9">
                       <input type="text" name="description" class="form-control live" required 
                       placeholder="App Description" data-class=".live-discription" />
                    </div>
                    </div>

                     <!-- START  price FIELD -->
                   <div class="form-group form-group-lg">
                    <label class="col-sm-3 control-label">Price</label>
                    <div class="col-sm-9 col-md-9">
                       <input type="number" min='0' max="9999" name="price" class="form-control live" data-class='.live-price' required

                       placeholder="App price" />
                    </div>
                    </div>

                     <!-- START  Country of Made FIELD -->
                   <div class="form-group form-group-lg">
                    <label class="col-sm-3 control-label">Developer</label>
                    <div class="col-sm-9 col-md-9">
                       <input type="text" name="developer" class="form-control"  required
                       placeholder="Developer" />
                    </div>
                    </div>
                     <!-- START  Category  FIELD -->
                   <div class="form-group form-group-lg">
                    <label class="col-sm-3 control-label">Category</label>
                    <div class="col-sm-9 col-md-9">
                      <select name="category" >
                        <option value="">...</option>
                        <?php 
                        $cats =getTable('categories');
                        //$subCat=getTable('categories','Parent',$cat['ID']);
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
              

                     <!-- START  Tags FIELD -->
                   <div class="form-group form-group-lg">
                    <label class="col-sm-3 control-label">Tags</label>
                    <div class="col-sm-9 col-md-9">
                       <input type="text" name="tags" class="form-control"  
                       placeholder="Tags separet by comma ' , ' " />
                    </div>
                    </div>
                    
                    <!-- START image FIELD -->
                 <div class="form-group form-group-lg">
                    <label class="col-sm-3 control-label">image</label>
                    <div class="col-sm-9 col-md-9">
                       <input type="file" name="image"  class="form-control" required="required" />
                    </div>
                    </div>
                    <!-- START screenshot1 FIELD -->
                 <div class="form-group form-group-lg">
                    <label class="col-sm-3 control-label">screenshot 1</label>
                    <div class="col-sm-9 col-md-9">
                       <input type="file" name="image1"  class="form-control" required="required" />
                    </div>
                    </div>
                    <!-- START screenshot2 FIELD -->
                 <div class="form-group form-group-lg">
                    <label class="col-sm-3 control-label">screenshot 2</label>
                    <div class="col-sm-9 col-md-9">
                       <input type="file" name="image2"  class="form-control"  required="required" />
                    </div>
                    </div>
                    <!-- START screensho3 FIELD -->
                 <div class="form-group form-group-lg">
                    <label class="col-sm-3 control-label">screenshot 3</label>
                    <div class="col-sm-9 col-md-9">
                       <input type="file" name="image3"  class="form-control" hidden="hidden" required="required" />
                    </div>
                    </div>
                    <!-- START screenshot4 FIELD -->
                 <div class="form-group form-group-lg">
                    <label class="col-sm-3 control-label">screenshot 4</label>
                    <div class="col-sm-9 col-md-9">
                       <input type="file" name="image4"  class="form-control" required="required" />
                    </div>
                    </div>

                    <!-- START Submit FIELD -->
                   <div class="form-group form-group-lg">

                    <div class="col-sm-offset-2 col-sm-20">
                       <input type="Submit" value="UPLOAD" class="btn btn-success btn-lg" >
                    </div>
                    </div>
              </form>


                </div>
                <div class="col-md-4">
                 <div class='thumbnail item-box live-preview'>
 <span class='price-tag live-price'>Price</span>
 <img class='img-responsive' src='android.png' alt='img'>
 <div class='caption'>
      <h3 class="live-name">name</h3>
      <p class='live-discription' data-class="description">Description</p>
      </div>
   </div>
                </div>
                </div>
                          
                          <?php 
                          if (!empty($formErrors)) {
                              foreach ($formErrors as $error) {
                                  echo "<div class='alert alert-danger'>".$error.'</div>';
                              }
                          }else{

                          }


                          ?>

			 </div>
		</div>
	</div>	
</div>

<?php

    }else{
    	header("Location:login.php");
    	exit();
    }
    include $tpl.'footer.php';
    ob_end_flush();
