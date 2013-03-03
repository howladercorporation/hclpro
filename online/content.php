<?php

switch ($page) {
    case 'main':
        include('contents/main.php');
        break;
    case 'newuser':
        include('contents/addnewuser.php');
        break;
    case 'newproject':
        include('contents/newproject.php');
        break;
    case 'showallusers':
        include('contents/showalluser.php');
        break;
    case 'edituser':
        include('contents/edituser.php');
        break;
    case 'newtask':
        include ('contents/newtask.php');
        break;
    case 'viewproject':
        include('contents/viewproject.php');
        break;
    default :
        include('contents/temp.php');
}

?>