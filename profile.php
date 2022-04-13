<?php
ob_start();
    session_start();

    include "init.php"; 
    if (isset($_SESSION['user'])) {
    $userInfo = $con->prepare('SELECT * FROM users WHERE UserName = ?');
    $userInfo->execute(array($sessionUser));
    $info = $userInfo->fetch();

   
    ?>
  
   
<h1 class="text-center">My Profile</h1>

<div class="information">
	<div class="container">
		<div class="panel panel-primary ">
			<div class="panel-heading">
				Main Information
			</div>
			<div class="panel-body">
				<ul class="list-unstyled">
					
				<li><i class="fa fa-user fa-fw"></i>  <span>Name : </span><?php echo $info['UserName']?></li>
				<li><i class="fa fa-envelope-o "></i> <span>Email : <?php echo $info['Email']?></li>
				<li><i class="fa fa-user fa-fw"></i>  <span>FullName : </span><?php echo $info['FullName']?></li>
				<li><i class="fa fa-calendar fa-fw"></i> <span>Regester Date : </span><?php echo $info['Date']?></li>
				<li><i class="fa fa-lock fa-fw"></i> <span>RegStatus : </span><?php
				 $Active=$info['RegStatus']?'Active':'Not Active';
				 	echo $Active;?></li>
				
				<li><i class="fa fa-tags fa-fw"></i> <span>Favorite Category :</span></li>
				</ul>
                 <form action="edit.php?do=profile" method="post">
                  <input type="hidden" name="userid" value="<?php echo $info['UserID'] ?>"/>
                  <input type="submit" class="btn btn-primary pull-right" value="Edit">
                 </form>
				 <!--<a class="btn btn-primary pull-right" href="edit.php?do=profile&UserId=<?php echo $info['UserID'];?>">Edite</a>-->

			</div>
		</div>
	</div>	
</div>

<div id='my-ads' class="my-ads">
	<div class="container">
		<div class="panel panel-primary block">
			<div class="panel-heading">
				My APPS
			</div>
			<div class="panel-body">
						 <div class="row">
    	
					<?php 
					foreach (getItems("Member_ID",$info['UserID']) as $item) {
					 echo "<div class='col-xs-12 col-sm-4 col-md-2'>";
  echo "<div class='thumbnail item-box'>";
  
  if ($item['Approve']==0) {
    echo "<span class='approve'>Waiting Approve</span>";
  }
  if (empty($item['Image'])) {
    echo "<img class='img-responsive' src='android.png' alt='img'>";
  }else
      echo "<a class='black' href='items.php?Item_ID=".$item['Item_ID']."'>";
  echo "<img class='img-responsive' src='admin/uploads/images/".$item['Image']."' alt='img'>";
  echo "<div class='caption'>";
       echo "<div class='app-name'>"; 
      echo "<h4>";
                 echo $item['Name']."</h4></a>";
                 echo "</div>";
      /* echo "<p>".$item['Description']."</p>";*/
      
          
      
   //    if ($item['Rating']!=0) {
         
         // echo "<span class='pull-right'>".$item['Rating'].'<i class="fa fa-star shine"></i></sapn>';
       echo '<div class="ratings">
  <div class="empty-stars"></div>
  <div class="full-stars" style="width:'.($item['Rating']*20).'%"></div>
</div>';
  //     } if END

echo "<span class='pull-right app-price'>";
  if ($item['Price'] == 0 ) 
    echo "Free";
  else 
    echo $item['Price'].'$';

  echo "</span>";
       echo "</div>";
    echo "</div>";
echo "</div>";

					}


?>

 							</div>
			</div>
		</div>
	</div>	
</div>

<div class="comments">
	<div class="container">
		<div class="panel panel-primary block">
			<div class="panel-heading">
				comments
			</div>
			<div class="panel-body">
				 <?php
              $stmt = $con->prepare("SELECT comment FROM comments
                   
                WHERE user_Id = ?
          "); 

       	$stmt->execute(array($info['UserID']));

       	$comments = $stmt->fetchAll();
       	if(!empty($comments)){
       		foreach ($comments as $comment) {
       			echo "<p>".$comment['comment']."</p>";
       		}

       	}else{
       		echo "there is No Comment To Show";
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
    if (isset($_GET['do'])){

    $do = $_GET['do'];
    if ($do=="delete") {
	$Item_ID = isset($_GET['Item_ID']) && is_numeric($_GET['Item_ID']) ? intval($_GET['Item_ID']) : 0 ;

       $stmt = $con->prepare("SELECT *
            FROM items WHERE Item_ID = ?
            LIMIT 1 ");


      $stmt->execute(array($Item_ID));
      $row = $stmt->fetch();
      $count = $stmt->rowCount();


       if ($count>0) { 

         //unlink('admin/uploads/apps/'.$row['App']);
         unlink('admin/uploads/images/'.$row['Image']);
         $images = getTable("images","Item_id",$Item_ID);
         foreach ($images as $img) {
         	unlink('admin/uploads/DescImages/'.$img['Image']);
         }

        $stmt = $con->prepare("DELETE FROM items WHERE Item_ID = :Item_ID ");
        $stmt->bindParam(':Item_ID',$Item_ID);
        $stmt->execute();    
       // echo '<div class="alert alert-success">'.'Record updated '.'</div>';
         redirect('Record Deleted ','back',2);

     
     }}
    }
    
    include $tpl.'footer.php';
    ob_end_flush();
