<?php # Script 17.3 - index.php
// This is the main page for the site. AKA HOME





if (isset($_SESSION['userAccess'])) { //if logged in
    include("includes/functions.inc.php");

    if ($_SESSION['userAccess'] == 1){ //client
        redirect_user('summary.php');
        
    }elseif($_SESSION['userAccess'] == 99){ //admin
        redirect_user('admin.php');
    }
}else{ // no one logged in - display art or something
    //DESTROY SESSION HERE
    //set page title and heading
    include ('includes/header.html'); //included for page title to work

    include('login_pg.html');
}
// Include the HTML footer file:
include ('includes/footer.html'); //include (CHAPTER_PATH.'/'.$chapter.'/includes/17.2.php');
?>