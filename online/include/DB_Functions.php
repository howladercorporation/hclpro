<?php

/*
 * Created by: Shahin
 * Create Date: 23/02/2013 (dd/MM/yyyy)
 * Use for all database funtionality
 */

class DB_Functions {

    private $db;
    public $response = array("success" => 0, "error" => 0);

    //Constructor
    function __construct() {
        require_once 'DB_Connect.php';

        //Create object for class DB_Connect
        $this->db = new DB_Connect();

        //Open the mysql database connection
        $this->db->connect();
    }

    //Destructor
    function __destruct() {
        
    }

    /*
     * Check user login
     * If the user is ok then return user information
     * Otherwise return error message
     */

    public function LoginUserByUserNameAndPassword($username, $password) {
        if ($username == "" || $password == "") {
            $response["error"] = 1;
            $response["error_msg"] = "Please fill all information.";
            return $response;
        }
        $query = "select * from users where username='$username' and active='Y'";
        //echo $query;
        $result = mysql_query($query); // or die(mysql_error());
        // check for result 
        $no_of_rows = mysql_num_rows($result);

        if ($no_of_rows > 0) {
            $result = mysql_fetch_array($result);

            $encrypted_password = $result['userpass'];
            $hash = $this->checkhashSSHA($result['salt'], $password);

            // check for password equality
            if ($encrypted_password == $hash) {
                // user authentication details are correct
                $response["error"] = 0;
                $response["success"] = 1;
                $response["userid"] = $result['id'];
                $response["username"] = $result['fname'] . " " . $result['lname'];
                $response["usertype"] = $result['usertype'];
                return $response;
            } else {
                $response["error"] = 1;
                $response["error_msg"] = "Invalid user name or password!";
                return $response;
            }
        } else {
            $response["error"] = 1;
            $response["error_msg"] = "Invalid user name or password!";
            return $response;
        }
    }

    public function addNewUser($fname, $lname, $username, $email, $pass, $usertype) {
        if ($fname == "" || $lname == "" || $username == "" || $email == "" || $pass == "") {
            $response["error"] = 1;
            $response["error_msg"] = "Please fill all information.";
            return $response;
        }
        if ($this->isUserEmilExisted($email)) {
            $response["error"] = 1;
            $response["error_msg"] = "The email already used!";
            return $response;
        }

        if ($this->isUsernameExisted($username)) {
            $response["error"] = 1;
            $response["error_msg"] = "The username already used!";
            return $response;
        }
        $hash = $this->hashSSHA($pass);
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"]; // salt
        $id = date("YmdHis") . rand(100000, 999999);
        $id = sha1($id);

        $query = "INSERT INTO `users`(`id`,`username`, `userpass`, `salt`, `fname`, `lname`, `email`, `usertype`, `active`) VALUES ('$id','$username','$encrypted_password','$salt','$fname','$lname','$email',$usertype,'N')";


        $result = mysql_query($query);
        if ($result) {
            $this->sendEmilForAccountActivation($id, $username, $pass, $email);
            $response["error"] = 0;
            $response["success"] = 1;
            $response["msg"] = "The user create successfully!";
            return $response;
        } else {
            $response["error"] = 1;
            $response["error_msg"] = "Oops... Something is wrong!";
            return $response;
        }
    }

    public function addNewProject($title, $description){
        if($title==""){
            $response["error"] = 1;
            $response["error_msg"] = "Please fill all information.";
            return $response;
        }
        
        $userid = $_SESSION['userid'];
        $date = date("YmdHis");
        
        $query = "INSERT INTO `projects`(`title`,`description`, `userid`, `setdate`) VALUES ('$title','$description','$userid','$date')";
        
     
        $result = mysql_query($query);
        if($result){            
            $response["error"] = 0;
            $response["success"] = 1;
            $response["msg"] = "The Project has been created successfully!";
            return $response;
        }else{
            $response["error"] = 1;
            $response["error_msg"] = "Oops... Something is wrong!";
            return $response;
        }
    }

    public function sendEmilForAccountActivation($id, $username, $pass, $email) {

        $to = $email;
        $subject = 'New user';
        $from = 'hcl@howladergroup.com';
        $message = '';
        $message.='<table width="400" border="0" style="font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 12px;">';
        $message.='<tr>';
        $message.= '<td colspan="2">Your login details are listed below. Please keep it for future reference:</td>';
        $message.='</tr>';
        $message.='<tr>';
        $message.= '<td width="110"><strong>Username</strong></td>';
        $message.= '<td width="280">' . $username . '</td>';
        $message.= '</tr>';

        $message.= '<tr>';

        $message.= '<td><strong>Password</strong></td>';

        $message.= '<td>' . $pass . '</td>';

        $message.= '</tr>';

        $message.='<tr>';
        $message.= '<td colspan="2">Please click the link for activate your account</td>';
        $message.='</tr>';

        $message.='<tr>';
        $message.= '<td colspan="2"><a href="http://www.howladergroup.com/hclpro/online/activation.php?id=' . $id . '">http://www.howladergroup.com/hclpro/online/activation.php?id=' . $id . '</a></td>';
        $message.='</tr>';

        $message.= '</table>';
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From:' . $from . "\r\n";
        $mail = mail($to, $subject, $message, $headers);
        return $mail;
    }

    public function ActivateUser($id) {
        $query = mysql_query("SELECT * from users WHERE id = '$id'");
        $no_of_rows = mysql_num_rows($query);
        if ($no_of_rows > 0) {
            $query = "UPDATE `users` SET `active`='Y' WHERE `id`='$id'";
            $result = mysql_query($query);
            if ($result) {
                $response["error"] = 0;
                $response["success"] = 1;
                $response["msg"] = "Activated successfully!";
                return $response;
            } else {
                $response["error"] = 1;
                $response["error_msg"] = "Oops... Something is wrong!";
                return $response;
            }
        } else {
            $response["error"] = 1;
            $response["error_msg"] = "Oops... Something is wrong!";
            return $response;
        }
    }

    public function totalRowInUsers() {
        $query = "SELECT COUNT(*) as num FROM users";
        $total_pages = mysql_fetch_array(mysql_query($query));
        $total_pages = $total_pages['num'];
        return $total_pages;
    }

    public function getProjectsInfoWithStartAndLimit($start, $limit) {
        $query = "SELECT * FROM projects LIMIT $start, $limit";
        $result = mysql_query($query);
        return $result;
    }

    public function getUsersInfoWithStartAndLimit($start, $limit) {
        $query = "SELECT * FROM users LIMIT $start, $limit";
        $result = mysql_query($query);
        //$result = mysql_fetch_array($result);
        return $result;
    }

    /**
     * Check user email is existed or not
     */
    public function isUserEmilExisted($email) {
        $result = mysql_query("SELECT * from users WHERE email = '$email'");
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            // user email existed 
            return true;
        } else {
            // user email not existed
            return false;
        }
    }

    /**
     * Check username is existed or not
     */
    public function isUsernameExisted($username) {
        $result = mysql_query("SELECT * from users WHERE username = '$username'");
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            // username existed 
            return true;
        } else {
            // username not existed
            return false;
        }
    }

    /**
     * Encrypting password
     * @param password
     * returns salt and encrypted password
     */
    public function hashSSHA($password) {

        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }

    /**
     * Decrypting password
     * @param salt, password
     * returns hash string
     */
    public function checkhashSSHA($salt, $password) {

        $hash = base64_encode(sha1($password . $salt, true) . $salt);

        return $hash;
    }

    /**
     * This function use for forgot password request
     * @param user email id
     * If the email is not found at database then retrun 0
     * If the email is found but the user is not activeated then return 1
     * If the user is ok then retrun 2
     * If the user is ok and also send mail success then retrun 3
     */
    public function forgotPasswordRequest($email) {
        $isUserFound = $this->isUserExisted($email);

        //If the email is found
        if ($isUserFound) {
            $isActiveUserFound = $this->isActiveUserExisted($email);
            //If active user found
            if ($isActiveUserFound) {
                $mail = $this->sendEmailToTheUser($email);
                if ($mail)
                    return 3;
                return 2;
            }
            //If the email found but the user is not activated
            return 1;
        }
        //If the email is not found
        else {
            return 0;
        }
    }

    /**
     * Use for send email
     * @param email address
     */
    private function sendEmailToTheUser($email) {
        $query_string = "select * from users where email = '" . $email . "'";
        $res = mysql_query($query_string);
        $rows = mysql_fetch_array($res);
        $to = $email;
        $subject = 'Forgot Password';
        $from = 'admin@admin.com';
        $message = '';
        $message.='<table width="400" border="0" style="font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 12px;">';
        $message.='<tr>';
        $message.= '<td colspan="2">Your login details are listed below. Please keep it for future reference:</td>';
        $message.='</tr>';
        $message.='<tr>';
        $message.= '<td width="110"><strong>Username</strong></td>';
        $message.= '<td width="280">' . $rows["email"] . '</td>';
        $message.= '</tr>';

        $message.= '<tr>';

        $message.= '<td><strong>Password</strong></td>';

        $message.= '<td>' . $rows["password"] . '</td>';

        $message.= '</tr>';

        $message.= '</table>';
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From:' . $from . "\r\n";
        $mail = mail($to, $subject, $message, $headers);
        return $mail;
    }

    /*  This function will be
     *  used to get all project name and id  */

    public function getProjectInformation() {
        $query = "select * from projects";
        $result = mysql_query($query);
        return $result;
    }

}
?>


