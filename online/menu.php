<?php 
    if($_SESSION['usertype']=='1')
        include("menu/adminmenu.php");
    else
        include("menu/usermenu.php");
?>