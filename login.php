<?php 
ob_start();
session_start();
   
    $pageTitle= 'Login';
    if(isset($_SESSION['user']))
    	 header('Location: index.php');
include 'init.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if(isset($_POST['login'])){

    	$UserName 	= $_POST['username'];
    	$password 	= $_POST['password'];
    	$hashedPass = sha1($password);
    	


    	//check if User in DATABASE.
    	$stmt = $con->prepare("SELECT UserName , Password , UserID
            FROM users WHERE UserName = ? 
            AND password = ? 
            ");
    	$stmt->execute(array($UserName,$hashedPass)); 

    	$getinfo=$stmt->fetch(); 
    	$count = $stmt->rowCount();       
    	//echo $count;
    	// if Count > 0   ==>  DB contain info about this UserName
    	if ($count > 0 )
           $_SESSION['user'] = $UserName; // reg Session Name
           $_SESSION['theUserID'] = $getinfo['UserID']; // reg Session userID

          
        header('Location: index.php'); // go to index.php
          exit();
    
	 }else{
	 	$password   = $_POST['password'];
	 	$password2  = $_POST['password2'];
	 	$email      = $_POST['email'];
	 	$hashpass   = sha1($password);

	 	$formErrors =array();
	 	if (isset($_POST['username'])) {
	 		$filteredUser=filter_var($_POST['username'],FILTER_SANITIZE_STRING);
	 		$username=$filteredUser;
	 		
	 	 if (strlen($filteredUser)<3 || strlen($filteredUser)>26) {
	 	 	$formErrors[]='the UserName must be Larger than 3 characters and shorter Than 26 characters.';
	 	 }
	 	}

	  }if (isset($password )&&isset($password2)) {
	  	
        if (empty($password)) {
        	$formErrors[]= 'Password is empty';
        }


	  	
	  	if ($password===$password2) {
	  		
	  	}else{
	  		$formErrors[]='confirm password is incorrect';
	  	}

	  }
	  if (isset($_POST['email'])) {
	 		$filteredEmail=filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);

	 		
	 	 if (filter_var($filteredEmail,FILTER_VALIDATE_EMAIL)==false) {
	 	 	$formErrors[]='invalid Email';
	 	 }
	 	}
    }

?>
<!--  class="daci" id="particles-js"-->

	
<div class="container login-page">
	<h1 class="text-center">
		<span class="selected" data-class='login'>Login</span> |
		<span   data-class='signup'>Signup</span>
	</h1>
	<form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method='POST'>
		<div class="input-container">
		<input type="text" name="username" class="form-control" autocomplete="off" placeholder='username'   
         
		 required>
		</div>
		<div class="input-container">
		<input type="password" name="password" class="form-control"  
          
		  placeholder='password' required>
        </div>
		<input type="submit" name="login" value='Login' class="btn btn-primary btn-block" autocomplete="new-password">
	</form>





	<form class="signup" method="POST">
		<div class="input-container">
		<input type="text" name="username" class="form-control" autocomplete="off" placeholder='username' pattern=".{4,25}" 
         title="username must be between 4 and 25 chars" required>
</div>
<div class="input-container">
		<input type="email" name="email" class="form-control"  placeholder='email' required>
</div>
<div class="input-container">
		<input type="password" name="password" class="form-control" autocomplete="new-password"  placeholder='password' minlength="4"  required>
</div>
<div class="input-container">
		<input type="password" name="password2" class="form-control" autocomplete="new-password" placeholder='comfirm password' minlength="4"  required>
</div>
		<input type="submit" name="signup" value="Signup" class="btn btn-success btn-block" >
	</form>
<div class="errors text-center">
	<?php 
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (!empty($formErrors)) {
    	foreach ($formErrors as $error) {
    		echo $error.'<br/>';
    	}
    }else{
    	
        if(checkItem("UserName","users",$username)>0){
        
        	redirect("sorry the user is exist",'back',3);
        }else {  
       

              $stmt = $con->prepare("INSERT users (UserName, Password, Email,RegStatus,Date) 
              	                     VALUES ( :zuser , :zpass  , :zemail,0,now())"); // or ( ?,..) or ($var ,..)
              $stmt->execute( array( 
               'zuser' => $username,
               'zpass' => $hashpass,
               'zemail'=> $email
                ));
                //echo success Message
              // $stmt->rowCount(); it doesnt Work and I dont know why !!
                header('Location:suc.php');
               
              }
        
    }
}

	?>

</div>





















</div>
<?php 
include $tpl.'footer.php';
ob_end_flush();
?>