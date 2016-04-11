<?php
// This page handles additional errors & sets session array
// after being accessed via JS within the login_pg.php script
// functions page provides 1st query return here!


require('../mysqli_connect.php');//requires database connection

if(isset($_GET['email'], $_GET['password'])){
    session_start(); //start session
    
    //CHECK FOR ALREADY EXISTING EMAIL - 04-26 update
    $email = mysqli_real_escape_string($dbc, trim($_GET['email']));
    $pass = mysqli_real_escape_string($dbc, trim($_GET['password']));
    $q = "SELECT userID FROM t_users WHERE email='$e' && pass!=SHA1('$pass')";
    if ($r = @mysqli_query($dbc, $q)) {
        if(mysqli_num_rows($r) != 0) {
        $_SESSION['errors'] = 'Your password may be incorrect - this email already registered.'; //again - check for needed error naming!
        }elseif(mysqli_num_rows($r) == 0){
    
            mysqli_free_result($r); // free the query result

            if(isset($_SESSION['errors'])) {
                unset($_SESSION['errors']);
            }
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                // Retrieve the user_id and first_name for that email/password combination: SET THIS STILL!!!
                $q = "SELECT userID, fName, lName, addr, town, steCode, zip, userAccess FROM t_users WHERE email='$email' AND pass=SHA1('$pass')";	
                $r = mysqli_query ($dbc, $q); // Run the query.

                if (mysqli_num_rows($r) == 1) {// if result returned
                    $row = mysqli_fetch_array($r, MYSQLI_ASSOC); // Fetch the record

                    if($row['userAccess'] == 'admin'){ //if predetermined user is admin
                        $_SESSION['userAccess'] = 99;

                    }else{
                        //declare variables from row
                        $_SESSION['userAccess'] = 1;
                        $_SESSION['userID'] = $row['userID'];
                        $_SESSION['fName'] = $row['fName'];
                        $_SESSION['lName'] = $row['lName'];
                        $_SESSION['addr'] = $row['addr'];
                        $_SESSION['town'] = $row['town'];
                        $_SESSION['steCode'] = $row['steCode'];
                        $_SESSION['zip'] = $row['zip'];
                        $_SESSION['email'] = $email;
                        $_SESSION['pass'] = $pass;
                        mysql_free_result($r);
                        }

                }else{ //not currently in database - NEW CUSTOMER
                    $_SESSION['userAccess'] = 1;
                    $_SESSION['email'] = $email;
                    $_SESSION['pass'] = $pass;

                }//end return query

                echo 'You are now logged in'; //response to JS IN FOOTER
                mysqli_close($dbc); //close dbc
                exit();
            }else{ //email not validated
                $errors['e'] = 'Please provide a valid email address.';
                $_SESSION['errors'] = $errors;
            } //end if validate email
        } //if email not already used
    }//if true query database
    //reload home page to reveal login status
    //redirect_user('index.php'); HOPEFULLY THIS WORKED IN JQUERY
} //end isset email and password
?>