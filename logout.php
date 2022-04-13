<?php  

 // start the Session 
    session_start();

    session_unset(); // unset data 

    session_destroy();

    header('Location: index.php');
    exit();



