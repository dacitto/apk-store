

<nav class="navbar navbar-fixed-top">


  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
       
      </button>
      <a class="navbar-brand" href="index.php">
        <i class="fa fa-android Mybrand"></i> 
      ApkStore</a>
    </div>
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav navbar-right">
      <?php  
      
   foreach (getCats() as $cat) {
    if ($cat['Visibility']==0 & $cat['Parent']==0) {
      
    echo "<li>";
    echo "<a href='categories.php?pageId=".$cat['ID']./*"&pageName=".str_replace(" ", '-', $cat['Name']).*/" ' >";
   
    echo $cat['Name']."</a></li>";
    }
   }

   if (!isset($_SESSION['user'])) { 
      ?>
     
     <li>
  <a href="login.php" class="">Login/Singup</a>
    </li>
      </ul>
    <?php  } ?>
    <div class="adresses pull-right">
    <?php 
      if (isset($_SESSION['user'])) { 
      ?>
      <div class="btn-group my-info">
        <span class="btn dropdown-toggle" data-toggle='dropdown'>
          <?php

          if (empty(getAvatar($_SESSION['theUserID']))){
            echo '<img src="admin\uploads\user.png" class="img-responsive avatar-size img-thumbnail img-circle">';  
          }else{
          echo '<img src="admin/uploads/avatars/'.getAvatar($_SESSION['theUserID']) .'" class="img-responsive avatar-size img-thumbnail img-circle">';  
          }
      
        echo $sessionUser; ?>
        <span class="caret"></span>
        </span>
        <ul class="dropdown-menu">
        <li><a href='profile.php'><i class="fa fa-user"></i>  My Profile</a></li>
        <li><a href='profile.php#my-ads'><i class="fa fa-android"></i>  My Apps</a></li>
        <li><a href='newapp.php'><i class="fa fa-plus"></i>  New App</a></li>
        <li><a href='logout.php'><i class="fa fa-sign-out"></i>  Logout</a></li>
      </ul>
      </div>




</div>
     <?php
        if (checkRegStatus($sessionUser)==0){
           echo " ";
         
      }}else{
        
    ?>

  
   
  

      <?php } ?>


      </ul>
    </div>
</nav>

</div></nav>

<img src="images/hi.png" class="hi">

  <div class="up"> <i class="fa fa-android " ></i></div>