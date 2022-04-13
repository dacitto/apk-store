<?php
ob_start();
    session_start();

    include "init.php";
    $pageTitle ="Items"; 

    
     $Item_ID = isset($_GET['Item_ID']) && is_numeric($_GET['Item_ID']) ? intval($_GET['Item_ID']) : 0 ;

       $stmt = $con->prepare("SELECT 
            items.*, categories.Name AS Cat_Name ,users.UserName
            FROM items
            INNER JOIN 
            categories
            ON 
            categories.ID = items.Cat_ID
            INNER JOIN 
            users
            ON 
            users.UserID = items.Member_ID 
            WHERE Item_ID = ?
            AND Approve=1
            LIMIT 1 ");


      $stmt->execute(array($Item_ID));
      $count = $stmt->rowCount();



      if ($count>0) {
 $item = $stmt->fetch();
     	?>  
<h1 class="text-center"><?php echo $item['Name'];?></h1>
<div class='container'>
	<div class="row">
		<div class="col-md-4">
			<?php 
        if (empty($item['Image'])) {
    echo "<img class='img-responsive' src='android.png' alt='img'>";
  }else
  echo "<img class='img-responsive prodect-img' src='admin/uploads/images/".$item['Image']."' alt='img'>";
      ?>
		</div>
		<div class="col-md-8 item-info">

		
			<ul class="list-unstyled">
		<li><span><b>Last update :</b> <?php echo $item['Add_Date']?></span>	</li>	
		<li><span><b>Price :</b><?php
    if($item['Price']!=0) echo $item['Price'].'$';
    else
      echo "<b> Free</b>";

    ?> </span></li>
		<li><span><b>Devloper :</b> <?php echo $item['developer_Made']?></span></li>				
		<li><span><b>Category :</b> <?php echo $item['Cat_Name']?></span></li>				
		<li><span><b>Uploaded By :</b> <?php echo $item['UserName']?></span></li>   
<?php if ($item['Rating'] == 0){
  echo "<li><span><b>Rating :</b> Not Rates yet</span></li>";
}else { ?>
    <li><span><b>Rating :</b> <?php  echo '<div class="ratings">
  <div class="empty-stars"></div>
  <div class="full-stars" style="width:'.($item['Rating']*20).'%"></div>
</div>';   echo "<span class='rates-number'>  ".$item['Rating']." </span> Stars Based on ".$item['Rates'].
"<b> reviews </b>" ?></span></li>		
    <?php } ?>
    

      <li><span><b>Tags:</b></span>
       <?php
        $tags = explode(',',$item['Tags']);
        foreach ($tags as $tag) {
          $tag=str_replace(' ','',$tag);
          if (!empty($tag)) {
          echo "<a class='btn btn-primary' href='tags.php?name=".strtolower($tag)."' class='black'>{$tag}</a> ";
            }
        }
        
        ?>
      </li>

       <a class=' btn bg-maincolor btn-lg pull-right' href="<?php echo 'admin/uploads/apps/'.$item['App']; ?>"><i class="fa fa-download"></i> Download </a>
	</ul>
		</div>
	</div>
<hr class="custom-hr">  
<h2>Description :</h2>
    <p><?php echo $item['Description']?></p>
<div class="row">
  
   <?php   
    echo '<div class="col-md-2 description"> </div>';
       foreach (getTable('images','Item_Id',$item['Item_ID']) as $image){
    echo '<div class="col-md-2 description-img"> ';
   echo "<a href='admin/uploads/DescImages/".$image['Image']."' data-lightbox='appGal'><img class='img-responsive' src='admin/uploads/DescImages/".$image['Image']."' alt='img'></a>";
  echo '</div>' ;

       }
  ?>
    
 
  
  



</div>



<div class="row">


<?php
if (isset($_SESSION['user'])) {
 	$stmt = $con->prepare("SELECT *  FROM comments WHERE User_Id=? AND Item_Id=?   "); 

        $stmt->execute(array($_SESSION['theUserID'],$Item_ID));
      
        
        $count = $stmt->rowCount();



         
?>
  <div class="col-md-offset-3">
  <?php 
  
      if  ($count==0){

  ?>
    <div class="add-comment">
    <h3>Add your Comment</h3>
    <form action="<?php echo $_SERVER['PHP_SELF'].'?Item_ID='.$item['Item_ID'] ?>" method='POST'>
      <textarea name="comment" required></textarea>
       <!-- START rating FIELD -->

          <div class="rating text-center">
        <input type="radio" name="star" id="star5" value="5" ><label for="star5" ><i class="fa fa-star"></i></label>
        <input type="radio" name="star" id="star4" value="4" ><label for="star4" ><i class="fa fa-star"></i></label>
        <input type="radio" name="star" id="star3" value="3" checked><label for="star3" ><i class="fa fa-star"></i></label>
        <input type="radio" name="star" id="star2" value="2" ><label for="star2" ><i class="fa fa-star"></i></label>
        <input type="radio" name="star" id="star1" value="1" ><label for="star1" ><i class="fa fa-star"></i></label>
        
          </div>
                           
        
    <input type="submit" name="" value="Comment" class="btn btn-primary">
    </form>
    </div>
     <?php    } ?>
  </div>
<?php 
 
if($_SERVER['REQUEST_METHOD']=='POST'){
  $comment=filter_var($_POST['comment'],FILTER_SANITIZE_STRING);
  $userid =$_SESSION['theUserID'];
  $itemid =$item['Item_ID'];
  $rates  =floatval($item['Rates'])+1;
  $stars=$_POST['star'];
  $stars=floatval($stars);
  $rating=floatval($item['Rating']);
  
  echo $item['Rating'];
  
 $comment=str_replace('  ','',$comment);
  if (!empty($comment)||ctype_space($comment)||$comment==" ") {
    $stmt = $con->prepare("INSERT INTO 
      comments(Comment,Status,Comment_Date,Item_Id,User_Id,Rating_Stars)
       VALUES(:zcomment,1,NOW(),:zitemId,:zuserId,:zrating)");
    $stmt->execute(array(
      'zcomment' =>$comment  ,
      'zitemId' => $itemid ,
      'zrating' => $stars ,
      'zuserId' =>$userid ));

    
  $stmt2 = $con->prepare('UPDATE items SET Stars=Stars+?, Rates=? ,Rating=Stars/Rates WHERE Item_ID = ?');
      $stmt2->execute( array($stars,$rates,$itemid));

      
     
      header("Refresh:0");

    
       
	

 






  }if (!empty($stmt)) {
     
		echo " <br/>comment added";
	}else
  redirect("empty Comment !","",3);
}
}else{
	echo '<div class="col-md-offset-3"><a class="black" href="login.php">register or login</a> to add comment </div>';
}

?>

</div>

 


<?php 
$stmt = $con->prepare("SELECT comments.*,users.UserName,users.Avatar,users.UserID  FROM comments
                   
                   INNER JOIN
                   users
                   ON
                     users.UserID = comments.User_Id
                     WHERE Item_Id=?
                     AND Status=1
                     ORDER BY C_ID DESC 
                     
          "); 

       	$stmt->execute(array($item['Item_ID']));

       	$comments = $stmt->fetchAll();
        
        foreach ($comments as $comment) {
      
          ?>
    <div class='comment-box'>
        <div class='row'>
        	 <div class="col-md-1 text-center pull-left">
            <?php if(empty($comment['Avatar'])) {

              echo "<img src='admin/uploads/avatars/avatar.png' class='img-circle img-responsive center-block comment-avatar' >";
                 }
              else
                echo '<img src="admin/uploads/avatars/'.$comment['Avatar'].'" class="img-circle img-responsive center-block comment-avatar">';
              ?>
        	 	
           <?php echo $comment['UserName'] ?>
        	  </div>
        	<div class="col-md-10 bubble pull-left">  <?php echo $comment['Comment'] ?> 
            <div class="rating text-center pull-right">
         <?php 
           
              for ($i=1;$i<=5-$comment['Rating_Stars'];$i++){
                echo '<i class="fa fa-star"></i>';
              }
         for ($i=1;$i<=$comment['Rating_Stars'];$i++) { 
          echo '<i class="fa fa-star shine"></i>';}

          
        
       
          ?>

        
          </div> </div>
        </div>
    </div>

        <hr>
       	
<?php
        }

?>

	</div>







 
<?php
}
else 
    redirect('there is No such ID Or Item Waiting for Approve',"Back");

    ?>
  
   












<?php
   
    include $tpl.'footer.php';
    ob_end_flush();
