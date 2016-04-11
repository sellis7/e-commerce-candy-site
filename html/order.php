<?php # Script 17.4 - WAS forum.php
/*
*	File:   index.php
*	By:     Shaelyn Ellis
*	Date:   03.15.2014
*
*	This page shows up once a user (client) is logged in  
*       MAKE FORM STICKY FROM RETURNED QUERY IN FUNCTIONS THAT SET SESSION ARRAY IN LOGIN.PHP!
*
*=====================================
*/
//

?>
  <form id="candy" action = "" method = "post">
      <h2> Carrie's Candy Sales  </h2>

<!-- A borderless table of text widgets for name and address -->
<?php 

// determine and welcome returning or new customer - from login.php
if(isset($_SESSION['userID']) && !empty($_SESSION['userID'])) {
    printf("<p class='salut'><em>Welcome back, %s %s.</em></p>", $_SESSION['fName'], $_SESSION['lName']);
}else{
    echo "<p class='salut'><em>Welcome – we appreciate your new business.</em></p>";
}
?>
<div>
      <table id='order'>
        <tr>
            <td class="col1">Buyer's Name:</td> 
            <td><label for="fName">
           <input type="text"  name="fName" id="fName" size="30" maxlength="50" placeholder="FIRST NAME"
                     value ="<?php echo (isset($_SESSION['fName']) && !empty($_SESSION['fName']))? $_SESSION['fName'] : ''; ?>" />
          </label>
            </td>
          <td><label for="lName">  
          <input type="text"  name="lName" id="lName" size="30" maxlength="50" placeholder="LAST NAME"
                     value ="<?php echo (isset($_SESSION['lName']) && !empty($_SESSION['lName']))? $_SESSION['lName'] : ''; ?>"  />
          </label>
          </td>
        </tr>
        <tr>
            <td class="col1"><label for="street">Street Address: </label></td>
          <td colspan="2" > <input type="text"  name="addr" id="street" size="55" maxlength="150"
                     value ="<?php echo (isset($_SESSION['addr']) && !empty($_SESSION['addr']))? $_SESSION['addr'] : ''; ?>" />
          </td>
        </tr>
        <tr>
          <td class="col1"><label for="city">City: </label></td>
          <td> <input type="text"  name="town" id="city" size="30" maxlength="150"
                     value ="<?php echo (isset($_SESSION['town']) && !empty($_SESSION['town']))? $_SESSION['town'] : ''; ?>" />
          </td>
              
          <td><label for="state">State (2 letter): </label>
              <span class="tdIntd indSt"><input type="text"  name ="steCode" id="state" size="2" maxlength="2"
                     value ="<?php echo (isset($_SESSION['steCode']) && !empty($_SESSION['steCode']))? $_SESSION['steCode'] : ''; ?>" />
            </span>
          </td>
        </tr>
     
        <tr>
          <td class="col1"><label for="zip">Zip (5 digit): </label></td>
          <td> <input type="text"  name="zip" id="zip" size="5" maxlength="5"
                     value ="<?php echo (isset($_SESSION['zip']) && !empty($_SESSION['zip']))? $_SESSION['zip'] : ''; ?>" />
          </td>
        </tr>
        <tr>
            <td class="col1"><label for="email">Email address: </label></td>
          <td> <input type="text"  name="email" id="email" size="30" maxlength="60"
                     value ="<?php echo (isset($_SESSION['email']) && !empty($_SESSION['email']))? $_SESSION['email'] : ''; ?>" />
          </td>
        </tr>
        <tr>
          <td class="col1"><label for="pass1">Password: </label></td>
          <td> <input type="text"  name="pass1" id="pass1" size="12" 
                     value ="<?php echo (isset($_SESSION['pass']) && !empty($_SESSION['pass']))? $_SESSION['pass'] : ''; ?>"  />
          </td>
        </tr>
        <tr>
          <td class="col1"><label for="pass2">Confirm password: </label></td>
          <td> <input type="password"  name="pass2" id="pass2" size="12" />
          </td>
        </tr>
      </table>
      <input type="hidden"  name="userID" id="userID" value ="<?php echo (isset($_SESSION['userID']) && !empty($_SESSION['userID']))? $_SESSION['userID'] : ''; ?>" />

<!-- A bordered table for item orders -->
      <table id='products' border="border">
<!-- First, the column headings --> 
        <tr>
          <th> Product Name </th>
          <th> Price </th>
          <th> Quantity </th>
        </tr>

<!-- Now, the table data entries -->
<?php
    //query database for all current product listings
    $q = 'SELECT * FROM t_stock ORDER BY prodID';
    $r = mysqli_query ($dbc, $q);
    $i = 1;
    //iterate through stock table - WORKS!!!
    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
        echo "<tr>
            <td><label for=\"choc$i\">{$row['descrip']}"." ({$row['pieceWgt']} lb.)</label></td>
            <td>\${$row['price']}</td>
            <td> <input type='number'  name=\"{$row['prodID']}\" id=\"choc$i\" size ='2' /> </td>
            </tr>";
            
        $i++;
    }
?>
 
        </table>
</div>
  <!-- The radio buttons for the payment method -->
  <div>
        <h3> Payment Method: </h3>
        <table class="credit">
            <tr class="credit">
                <td>
                 <span>
          <input type = "radio"  name = "payment" id="visa"  value = "visa"
                 checked = "checked" /><label for="visa">&#32Visa </label>
                </span>
                <span>
          <input type = "radio"  name = "payment"  id="mc" value = "mc" />
          <label for="mc">&#32Master Card</label>
                </span>
               <span>    
          <input type = "radio"  name = "payment" id="discover"
                 value = "discover" /><label for="discover">&#32Discover</label>
               </span>
             </td>   
        </tr>
        <tr class="credit">
            <td class="indCC">
            <label for="acctNum">&#32Account #:</label>
            <input type="text"  name="acctNum" id="acctNum" maxlength="16"
                 placeholder="(any 16 digits)"/>
            </td>
            <td class="indCC">
                <label for="exp">&#32Expiration:</label>
                <input type="text"  name="exp" id="exp" size="12"
                 placeholder = "xx/xx" />
            </td>
        </tr>
        </table>
  </div>
  <!-- The submit and reset buttons -->
        <p class='buttons'>
            <input id="button" type="submit"  value="Submit Order" /> 
            <input type="reset"  value="Clear Order Form" />
        </p>
   
    </form>
<!-- <input type="text" name=myText value="Enter Your Name" readonly> TO VERIFY-->