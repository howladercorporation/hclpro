<?php
/*
 * Create by: Shahin
 * Create Date: 23/02/2013 (dd/MM/yyyy)
 * Use for create database connection
 */


class DB_Connect{
    //constructor
    function __construct() {
        
    }
    
    //Destructor
    function __destruct() {
        
    }
    
    //Connection to database
    public function connect(){
        require_once 'include/config.php';
        //include 'config.php';
        //Connect with mysql
        
        $con = mysql_connect(DB_HOST,DB_USER,DB_PASSWORD);
        
        //Select database 'startupn_startup'
        mysql_select_db(DB_DATABASE);
        
        //Return database connection handaler
        return $con;
    }
    
    //Close the database connection
    public function close(){
        //Close the database connection
        mysql_close();
    }
}
?>
