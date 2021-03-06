<?php # Script 17.x - mysqli_connect.php
// ONLY WHILE TESTING/DEBUGGING CODE
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

// This file contains the database access information.
// This file also establishes a connection to MySQL
// and selects the database.

// Set the database access information as constants:
DEFINE ('DB_USER', 'itp225');
DEFINE ('DB_PASSWORD', 'itp225');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'seChoc');

// Make the connection:
$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );

// Set the encoding...
mysqli_set_charset($dbc, 'utf8');

// Use this next option if your system doesn't support mysqli_set_charset().
//mysqli_query($dbc, 'SET NAMES utf8');



?>
