<?php
 	session_start();
 	if(isset($_SESSION['UserName'])){
 		//
 		$pageTitle = 'dashboard';
       include 'init.php';
       
?>
      
      <div class="container home-stats text-center"> 
      <h1>Dashboard</h1>
      <div class="row">
      	<div class="col-md-3">
          <a href="members.php">
            <div class="stat st-Tmembers">
          <i class="fa fa-users"></i>
          <div class="info">
              Total Memebres
             <span><?php echo countItems('UserID','users')?></span>
               </div>
            </div>
          </a>
      	</div>
      	<div class="col-md-3 ">
            <a href="members.php?do=manage&page=Pending">
          <div class="stat st-Pmembers">
            <i class="fa fa-user"></i>  
            <div class="info">
              Pending Memebres
              <span><?php echo checkItem("RegStatus","users",0) ?></span>

            </div>
          </div>
            </a>
      	</div>
      	<div class="col-md-3">
      		<a href="items.php">
            <div class="stat st-items">
             <i class="fa fa-tag"></i>
          <div class="info">
            Total 
            Apps 
            <span><?php echo countItems('Item_ID','items')?></span>
            </div>
          </div>
        </a>
      	</div>
      	<div class="col-md-3">
          <a href="comments.php">
          <div class="stat st-comments">
          <i class="fa fa-comments"></i>
          <div class="info">
            Total Comments<span><?php echo countItems('C_ID','comments')?></span>
          </div>
          </div>
        </a>
      	</div>
      </div>
  </div>

  <div class="container latest">
  	<div class="row">
  		
  		<div class="col-sm-6">
  			<div class="panel panel-default">
  				<div class="panel-heading">
  					<i class="fa fa-users"></i> 
            Latset Registered Users 
               <span class="toggle-info pull-right"><i class="fa fa-minus"></i></span>
          </div>
  					<div class="panel-body">
  						
  					 <ul class="list-unstyled latest-users">
  					 	
  						<?php
                            $latest=getLatest("*","users",5,'UserID');
                            foreach ($latest as $user) {
                            	echo '<li>'.$user['UserName'].
                            	"
                            	<a href= 'members.php?do=edit&UserId=".$user['UserID']  ."'>
                            	<span class ='btn btn-success pull-right'>
                            	<i class='fa fa-edit '></i>
                            	Edit 
 
                            	
                            	</span>
                            	</a>
                            	";
                            	if ($user['RegStatus']==0){
                  echo '<a href="members.php?do=activate&UserId='.$user['UserID'].'" class="btn btn-info activate pull-right"><i class="fa fa-exclamation"></i> Activate</a>';
                }
                  echo "</li >";
                            	
                            }
  						?>
  					 </ul>
  					</div>
  				</div>
  			</div>
      

  			<div class="col-sm-6">
  			<div class="panel panel-default">
  				<div class="panel-heading">
  					<i class="fa fa-tag"></i> Latset Apps added 
           <span class="toggle-info pull-right"><i class="fa fa-minus"></i></span>
          </div>
  					<div class="panel-body">
               <ul class="list-unstyled latest-users">
  						<?php
                            $latest=getLatest("*","items",5,'Item_ID');
                            foreach ($latest as $Item) {
                              echo '<li>'.$Item['Name'].
                              "
                              <a href= 'items.php?do=edit&Item_ID=".$Item['Item_ID']."'>
                              <span class ='btn btn-success pull-right'>
                              <i class='fa fa-edit '></i>
                              Edit           </span>
                              </a>
                              ";
                             if ($Item['Approve']==0){
                  echo '<a href="items.php?do=Approve&Item_ID='.$Item['Item_ID'].'"; class="btn btn-info  pull-right"><i class="fa fa-exclamation"></i> Approve</a>';
                }
                  echo "</li >";
                              
                            }
              ?> 
              </ul>
  					</div>
  				</div>
  			</div>
        

        

          <div class="col-sm-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            <i class="fa fa-comments"></i> Latset Comments added 
           <span class="toggle-info pull-right"><i class="fa fa-minus"></i></span>
          </div>
            <div class="panel-body">
              <?php
                        /* 
               <ul class="list-unstyled latest-users">
                           $latest=getLatest("*","comments",5,'C_ID');
                            foreach ($latest as $Item) {
                              echo '<li>'.$Item['Comment'].
                              "
                              <a href= 'items.php?do=edit&C_ID=".$Item['C_ID']."'>
                              <span class ='btn btn-success pull-right'>
                              <i class='fa fa-edit '></i>
                              Edit           </span>
                              </a>
                              ";
                             if ($Item['Status']==0){
                  echo '<a href="?do=Approve&C_ID='.$Item['C_ID'].'"; class="btn btn-info  pull-right"><i class="fa fa-exclamation"></i> Approve</a>';
                }
                  echo "</li >";
                              
                            }*/
                   $stmt = $con->prepare("SELECT comments.*,users.UserName AS Member  FROM comments
                   
                   INNER JOIN
                   users
                   ON
                     users.UserID = comments.User_Id 
                     ORDER BY C_ID DESC
                     LIMIT 5
                  
          "); 

        $stmt->execute();

        $rows = $stmt->fetchAll();
        if(!empty($rows)){
          foreach ($rows as $row){
           
           echo "<div class='comment-box'>";
           echo "<span class='member-n'>".$row['Member']."</span>";
           echo "<p class='member-c'>".$row['Comment']."</p>";
           echo "</div>";
          }



        }

        ?>



          
             
            </div>
          </div>
        </div>



  		</div>
  	</div>


  


<?php 

       include $tpl.'footer.php';
 	}
 	else{

 		header('Location: index.php');
 		exit();
 	}