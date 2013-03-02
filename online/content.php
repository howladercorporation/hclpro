<?php
    switch ($page){
       case 'main':
           include('contents/main.php');
           break;
       case 'newuser':
           include('contents/addnewuser.php');
           break;
       case 'showallusers':
           include('contents/showalluser.php');
           break;
       case 'edituser':
           include('contents/edituser.php');
           break;
       default :
           include('contents/temp.php');
       
    }
?>