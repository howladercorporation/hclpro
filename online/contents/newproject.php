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

$title = "";
$description = "";



if (isset($_POST['posted'])) {
    //echo '<section id="main" class="column"><h4 class="alert_success">A Success Message</h4></section>';
    $title = $_POST['title'];
    $description = $_POST['description'];
    
    
   $result = $db->addNewProject($title, $description);
        //print_r($result);
   if ($result['error'] == 0) {
            $title = "";
            $description = "";            
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
            <header><h3>New Project</h3></header>
            <div class="module_content">
                <fieldset style="width:48%; float: left;">
                    <label>Title</label>
                    <input type="text" name="title" required style="width:92%;" value="<?php echo $title; ?>">
                </fieldset>
                
                <fieldset style="width:70%; float: left;">
                    <label>Description</label>

                    <textarea rows="4" cols="50" name="description" style="width:92%;" value="<?php echo $description; ?>">
                    </textarea> 
                </fieldset>
                
                <div class="clear"></div>
            </div>
            <footer>
                <div class="submit_link">                
                    <input type="submit" value="Create Project" class="alt_btn">
                    <input type="reset" value="Reset">
                </div>
            </footer>
        </article><!-- end of post new article -->
    </form>
</section>


