<?php
    $id = $_GET['id'];
    require_once 'include/DB_Functions.php';
    $db = new DB_Functions();
    $result = $db->ActivateUser($id);
    if($result['error']==1){
        echo $result['error_msg'];
    }else{
        header('Location: ../');
    }
?>

