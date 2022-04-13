 <?php
ob_start();
    session_start();

    include "init.php";
  
  ?>
<div class="container">
 <!-- <h1 class="text-center"><?php //echo str_replace('-', ' ', $_GET['pageName']);?>Category</h1> -->

   <div id="myCarousel" class="carousel slide " data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li> 
      <li data-target="#myCarousel" data-slide-to="3"></li>
      <li data-target="#myCarousel" data-slide-to="4"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
      <div class="item active">
        <a href="http://localhost/ApkStore/items.php?Item_ID=15">
          
        <img src="images/banner/banner (1).jpg" alt="Los Angeles" style="width:100%;">
        </a>
      </div>

      <div class="item">
        <a href="items.php?Item_ID=13"> 
        <img src="images/banner/banner (2).jpg" alt="Chicago" style="width:100%;">
        </a>
      </div>
      
      <div class="item">
        <a href="items.php?Item_ID=12">
        <img src="images/banner/banner (3).jpg" alt="New york" style="width:100%;">
        </a>
      </div>

        <div class="item">
          <a href="http://localhost/ApkStore/items.php?Item_ID=16">
        <img src="images/banner/banner (4).jpg" alt="marican" style="width:100%;">
          </a>
      </div> 

         <div class="item">
          <a href="items.php?Item_ID=14">
        <img src="images/banner/banner (5).jpg" alt="marican" style="width:100%;">
          </a>
      </div>
 
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>



  <div class="row">
    
<?php 

// for ($i=0; $i < 2; $i++) 

foreach (getTable('items',"Approve",1) as $item) {
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
<?php 
   
    include $tpl.'footer.php';
    ob_end_flush();