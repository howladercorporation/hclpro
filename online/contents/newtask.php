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

$projectId = "";
$title = "";
$esttime = "";
$name = "";
$resultSet = $db->getProjectInformation();
if (isset($_POST['posted'])) {

    $projectId = $_POST['projectname'];
    $title = $_POST['title'];
    $esttime = $_POST['esttime'];


    if (is_uploaded_file($_FILES['descriptiondoc']['tmp_name'])) {
        if ($_FILES['descriptiondoc']['type'] == "application/pdf") {
            $name = 'project_task_doc/' . date("YmdHis") . rand(100000, 999999) . '.pdf';
            $result = move_uploaded_file($_FILES['descriptiondoc']['tmp_name'], $name);
            /* if ($result == 1)
              echo "<p>File successfully uploaded.</p>";
              else
              echo "<p>There was a problem uploading the file.</p>"; */
        } else if ($_FILES['descriptiondoc']['type'] == "application/msword") {
            $name = 'project_task_doc/' . date("YmdHis") . rand(100000, 999999) . '.doc';
            $result = move_uploaded_file($_FILES['descriptiondoc']['tmp_name'], $name);
            /*
              if ($result == 1)
              echo "<p>File successfully uploaded.</p>";
              else
              echo "<p>There was a problem uploading the file.</p>"; */
        }

        $result = $db->addNewTask($projectId, $title, $name, $esttime);
    }




    /*
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
      $result['error'] = 1;
      $result['error_msg'] = "Password and confirm password doesnot match.";
      } */
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


    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="posted" value="true" />
        <article class="module width_full">
            <header><h3>New Task</h3></header>
            <div class="module_content">
                <fieldset style="width:48%; float: left;">
                    <label>Project</label>
                    <select name="projectname" style="width:92%;">
                        <?php
                        
                        while ($row = mysql_fetch_array($resultSet)) {
                            ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['title']; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </fieldset>

                <fieldset style="width:48%; float: right;">
                    <label>Title</label>
                    <input type="text" name="title" required style="width:92%;" value="" >
                </fieldset>

                <fieldset style="width:48%; float: left;">
                    <label>Description</label>
                    <input type="file" name="descriptiondoc" required style="width:92%;" value="" >
                </fieldset>

                <fieldset style="width:48%; float: right;">
                    <label>Estimate Time (HOURS)</label>
                    <input type="number" name="esttime" required style="width:92%;" value="" >
                </fieldset>


                <div class="clear"></div>
            </div>
            <footer>
                <div class="submit_link">                
                    <input type="submit" value="Save" class="alt_btn">
                    <input type="reset" value="Reset">
                </div>
            </footer>
        </article><!-- end of post new article -->
    </form>
</section>

