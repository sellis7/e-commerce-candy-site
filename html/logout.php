<?php

# Script 17.11 - logout.php #2  BORROWED
// DIVERT USER TO THIS PAGE ONCE ORDER IS PLACED AND ALL IS OK - change to summary.php
// THIS PAGE CAN DISPLAY RECEIPT AND LET USER KNOW THEY ARE NOW LOGGED OUT
// comment to please return to home (with link), if they wish to order more


// This version uses sessions.
 
// If session variable exists, delete and redirect the user back to same page
//session_start();
if (isset($_SESSION['user_id']) && !isset($_GET['status'])) {
// Need the functions:
    require ('includes/functions.inc.php');
 
    $_SESSION = array(); // Clear the variables.
    // session_unset(); deprecated
    session_destroy(); // Destroy the session itself.
    setcookie (session_name(), '', time()-3600, '/', '', 0, 0); // Destroy the session cookie. 
    redirect_user('index.php?logout.php&status=loggedout');
} else {	
    include ('includes/header.html');
    // echo '<div id="content">';
    if(isset($_GET['status']) && $_GET['status']=='loggedout'){
    //confirm log out
        echo "<h1>Logged Out</h1>
        <p>Thanks for visiting. You are now logged out of our system.</p>";
    } else {
        echo '<p class="error">You need to log in before you can be logged out!<br />
        <a href="index.php?chapter=17&amp;script=17.9" title="Log In">Log in</a></p>';
    }
    // echo '</div>';
    include ('includes/footer.html');
}
?>