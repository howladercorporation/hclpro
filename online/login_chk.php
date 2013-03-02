<?php
    session_start();     
    $username = $_POST['login'];
    $userpass = $_POST['password'];
    if(!$username || !$userpass) 
    { 
        header('Location: ../'); 
    } 
    require_once 'include/DB_Functions.php';
    $db = new DB_Functions();
   
    
    $user = $db->LoginUserByUserNameAndPassword($username, $userpass);
    
    if($user['error']==1){
        $_SESSION['error_message']=$user['error_msg'];
        header('Location: ../'); 
        exit();
    }
    
    $_SESSION['error_message']="";
    $_SESSION['userid'] = $user['userid'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['usertype'] = $user['usertype'];

    header('Location: ../'); 

?> 
