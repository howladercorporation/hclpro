<?php
switch ($page) {
    case 'main':
        $head1 = "Main";
        $head2 = "Main";
        break;
    case 'newuser':
        $head1 = "Users";
        $head2 = "New User";
        break;
    case 'showallusers':
        $head1 = "Users";
        $head2 = "All Users";
        break;
    case 'edituser':
        $head1 = '<a href="?page=showallusers">Users</a>';
        $head2 = "Edit User";
}
?>
<header id="header">
    <hgroup>
        <h1 class="site_title"><a href="index.html">Task Management</a></h1>

    </hgroup>
</header> <!-- end of header bar -->

<section id="secondary_bar">
    <div class="user">
        <p><?php echo $_SESSION['username']; ?> (<a href="#">3 Messages</a>)</p>
        <!-- <a class="logout_user" href="#" title="Logout">Logout</a> -->
    </div>
    <div class="breadcrumbs_container">
        <article class="breadcrumbs"><a><strong><?php echo $head1; ?></strong></a> <div class="breadcrumb_divider"></div> <a class="current"><?php echo $head2; ?></a></article>
    </div>
</section><!-- end of secondary bar -->
