<?php
if ($_SESSION['usertype'] != '1') {
    ?>
    <section id="main" class="column">
        <h4 class="alert_error">You are not authorized person.</h4>
    </section
    <?php
    //echo '<h4 class="alert_error">An Error Message</h4>';
    exit();
}

if (isset($_POST['posted'])) {
    $userid = $_POST['userid'];
    $username = $_POST['username'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $usertype = $_POST['usertype'];
    $active = $_POST['active'];
    if ($pass == $conpass) {
        $result = $db->addNewUser($fname, $lname, $username, $email, $pass, $usertype);        
        if ($result['error'] == 0) {
            $fname = "";
            $lname = "";
            $username = "";
            $email = "";
        }
    } else {
        $result['error'] = 1;
        $result['error_msg'] = "Password and confirm password doesnot match.";
    }
} else {
    $userid = $_GET['id'];
    $user = $db->getUserInfoByUserId($userid);
    $fname = $user['fname'];
    $lname = $user['lname'];
    $username = $user['username'];
    $email = $user['email'];
    $usertype = $user['usertype'];
    $active = $user['active'];
}
?>


<section id="main" class="column">

    <?php
    if (isset($result)) {
        if ($result['error'] == 1) {
            echo '<h4 class="alert_error">' . $result['error_msg'] . '</h4>';
        } else {
            echo '<h4 class="alert_success">' . $result['msg'] . '</h4>';
        }
    }
    ?>

    <form action="" method="post">
        <input type="hidden" name="posted" value="true" />
        <input type="hidden" name="userid" value="<?php echo $userid; ?>"/>
        <input type="hidden" name="username" value="<?php echo $username; ?>"/>
        <article class="module width_full">
            <header><h3>New User</h3></header>
            <div class="module_content">
                <fieldset style="width:48%; float: left;">
                    <label>First Name</label>
                    <input type="text" name="fname" required style="width:92%;" value="<?php echo $fname; ?>">
                </fieldset>
                <fieldset style="width:48%; float: right;">
                    <label>Last Name</label>
                    <input type="text" name="lname" required style="width:92%;" value="<?php echo $lname; ?>" >
                </fieldset>
                <fieldset style="width:48%; float: left;">
                    <label>Username</label>
                    <input type="text" name="username" required style="width:92%;" value="<?php echo $username; ?>">
                </fieldset>
                <fieldset style="width:48%; float: right;">
                    <label>Email</label>
                    <input type="email" name="email" required style="width:92%;" value="<?php echo $email; ?>">
                </fieldset>                       
                <fieldset style="width:48%; float:left;"> <!-- to make two field float next to one another, adjust values accordingly -->
                    <label>User Type</label>
                    <select name="usertype" style="width:92%;">
                        <option value="2" <?php echo $usertype == '2' ? 'Selected=true' : '' ?>>User</option>
                        <option value="1" <?php echo $usertype == '1' ? 'Selected=true' : '' ?>>Admin</option>
                    </select>
                </fieldset>
                <fieldset style="width:48%; float:right;"> <!-- to make two field float next to one another, adjust values accordingly -->
                    <label>User Active</label>
                    <select name="active" style="width:92%;">
                        <option value="Y" <?php echo $active == 'Y' ? 'Selected=true' : '' ?>>Yes</option>
                        <option value="N" <?php echo $active == 'N' ? 'Selected=true' : '' ?>>No</option>
                    </select>
                </fieldset>
                <div class="clear"></div>
            </div>
            <footer>
                <div class="submit_link">                
                    <input type="submit" value="Update User" class="alt_btn">
                    <input type="reset" value="Reset">
                </div>
            </footer>
        </article><!-- end of post new article -->
    </form>
</section>


