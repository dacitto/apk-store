
<?php
ob_start();
session_start();

include 'init.php';

?>
<div class="container">
    
<?php 
if (isset($_GET['name'])){
	$tag =$_GET['name'];
  echo "<h1 class='text-center'>".$tag."</h1>";
  echo "<div class='row'>";
$items = getAllFrom("*", "items", "WHERE Tags like '%$tag%'","AND Approve=1","Item_ID","DESC") ;
foreach ($items as $item) {
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
}


?>

  </div>
</div>











<?php
include $tpl.'footer.php';
ob_end_flush();