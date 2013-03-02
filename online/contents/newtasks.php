<?php
if ($_SESSION['usertype'] != '1') {
    ?>
    <section id="main" class="column">
        <h4 class="alert_error">You are not authorized person.</h4>
    </section
    ><?php
    //echo '<h4 class="alert_error">An Error Message</h4>';
    exit();
}

$fname = "";
$lname = "";
$username = "";
$email = "";


if (isset($_POST['posted'])) {
    //echo '<section id="main" class="column"><h4 class="alert_success">A Success Message</h4></section>';
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $conpass = $_POST['conpass'];
    $usertype = $_POST['usertype'];
    if ($pass == $conpass) {
        $result = $db->addNewUser($fname, $lname, $username, $email, $pass, $usertype);
        //print_r($result);
        if ($result['error'] == 0) {
            $fname = "";
            $lname = "";
            $username = "";
            $email = "";
        }
    } else {
        $result['error']=1;
        $result['error_msg']="Password and confirm password doesnot match.";
    }
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
        <article class="module width_full">
            <header><h3>New User</h3></header>
            <div class="module_content">
                <fieldset style="width:48%; float: left;">
                    <label>ID</label>
                    <input type="text" name="fname" required style="width:92%;" value="<?php echo $id; ?>">
                </fieldset>
                <fieldset style="width:48%; float: right;">
                    <label>Project Id</label>
                    <input type="text" name="lname" required style="width:92%;" value="<?php echo $projectid; ?>" >
                </fieldset>
                <fieldset style="width:48%; float: left;">
                    <label>Task Title</label>
                    <input type="text" name="username" required style="width:92%;" value="<?php echo $tasktitle; ?>">
                </fieldset>
                <fieldset style="width:48%; float: right;">
                    <label>Desc File</label>
                    <input type="email" name="email" required style="width:92%;" value="<?php echo $descfile; ?>">
                </fieldset>
				<fieldset style="width:48%; float: right;">
                    <label>Estimate Duration</label>
                    <input type="email" name="email" required style="width:92%;" value="<?php echo $descfile; ?>">
                </fieldset>
				<fieldset style="width:48%; float: right;">
                    <label>Desc File</label>
                    <input type="email" name="email" required style="width:92%;" value="<?php echo $descfile; ?>">
                </fieldset>
				<fieldset style="width:48%; float: right;">
                    <label>Desc File</label>
                    <input type="email" name="email" required style="width:92%;" value="<?php echo $descfile; ?>">
                </fieldset>
				<fieldset style="width:48%; float: right;">
                    <label>Desc File</label>
                    <input type="email" name="email" required style="width:92%;" value="<?php echo $descfile; ?>">
                </fieldset>
				<fieldset style="width:48%; float: right;">
                    <label>Desc File</label>
                    <input type="email" name="email" required style="width:92%;" value="<?php echo $descfile; ?>">
                </fieldset>
				<fieldset style="width:48%; float: right;">
                    <label>Desc File</label>
                    <input type="email" name="email" required style="width:92%;" value="<?php echo $descfile; ?>">
                </fieldset>
                <fieldset style="width:48%; float: left;">
                    <label></label>
                    <input type="password" name="pass" required style="width:92%;" onchange="form.conpass.pattern = this.value;">
                </fieldset>
                <fieldset style="width:48%; float: right;">
                    <label>Confirm Password</label>
                    <input type="password" name="conpass" required style="width:92%;">
                </fieldset>         
                <fieldset style="width:48%; float:left; margin-right: 3%;"> <!-- to make two field float next to one another, adjust values accordingly -->
                    <label>User Type</label>
                    <select name="usertype" style="width:92%;">
                        <option value="2">User</option>
                        <option value="1">Admin</option>
                    </select>
                </fieldset>
                <div class="clear"></div>
            </div>
            <footer>
                <div class="submit_link">                
                    <input type="submit" value="Create User" class="alt_btn">
                    <input type="reset" value="Reset">
                </div>
            </footer>
        </article><!-- end of post new article -->
    </form>
</section>


