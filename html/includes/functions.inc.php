<?php
//# Script 12.2 - login_functions   NOT SURE IF NEEDED
// This page defines two functions used by the login/logout process.
 
// /* MOVED TO MAIN FUNCTION FILE FOR SITE WIDE USE
// * This function determines an absolute URL and redirects the user there.
// * The function takes one argument: the page to be redirected to.
// * The argument defaults to the login form of chapter 12.
// */
function redirect_user($page = 'index.php') {
 
// Start defining the URL...
// URL is http:// plus the host name plus the current directory:
$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
 
// Remove any trailing slashes:
$url = rtrim($url, '/\\');
// Add the page:
$url .= '/' . $page;
// Redirect the user:
header("Location: $url");
exit(); // Quit the script.
 
} // End of redirect_user() function.
 