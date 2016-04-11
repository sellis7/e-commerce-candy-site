<?php # Script 10.1 - view_users.php #3
// This script retrieves all the records from t_users
// for administrative purposes


    $myscript='admin.php';

    include ('includes/header.html'); //included for page title to work
    if(!isset($_SESSION['userAccess'])){
        exit('You have accessed this page in error');
    }else{
        require('../mysqli_connect.php');//requires database connection
        echo '<h1>Customer Records</h1>';

        include ('includes/table.inc.php');
    }
include ('includes/footer.html'); //included for page title to work

?>