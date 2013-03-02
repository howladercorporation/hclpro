<?php
session_start();
session_unset();
session_destroy();
header('Location: ../');
?>
<center><font face='Verdana' size='2' color=red>Logout successfully </font>( No session exist) <br> Visit Home page to <a href=index.php>Login</a></center>

