<?php
    session_start();
    $noNavbar = '';
    $pageTitle= 'Login';



    if(isset($_SESSION['UserName']))
    	 header('Location: dashboard.php'); // go to Dashboard.php
    include "init.php";
    //include $tpl.'header.php';
    //include 'includes/lang/english.php';
    //include 'includes/lang/arabic.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    	$UserName 	= $_POST['user'];
    	$password 	= $_POST['password'];
    	$hashedPass = sha1($password);
    	

    	//check if User in DATABASE.
    	$stmt = $con->prepare("SELECT UserName , Password ,UserID
            FROM users WHERE UserName = ? 
            AND password = ? 
            AND GroupID = 1
            LIMIT 1 ");


    	$stmt->execute(array($UserName,$hashedPass));

        $row = $stmt->fetch();   
    	$count = $stmt->rowCount();
        print_r( $row );
    	//echo $count;
    	// if Count > 0   ==>  DB contain info about this UserName

    	if ($count > 0 )
           $_SESSION['UserName'] = $UserName; // reg Session Name
           $_SESSION['ID'] = $row['UserID']; 
           header('Location: dashboard.php'); // go to Dashboard.php
          exit();
    }

    ?>

<form class="login text-center" action="<?php  echo $_SERVER['PHP_SELF'] ?>" method="post">
	<h4 class="text-center">Admin Login</h4>
	<input type="text"     class="form-control" name="user" placeholder="UserName" autocomplete="off">
	<input type="password" class="form-control" name="password" placeholder="Password" autocomplete="new-password">
	<input type="submit"   class="btn btn-primary btn-block" value="login">
    
<i class="fa fa-android "></i>
</form>






 
<?php  include $tpl.'footer.php';?>