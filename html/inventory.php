<?php #inventory.php 
/*	File:   inventory.php
*	By:     Shaelyn Ellis
*	Date:   04.26.2014
* 
*       This script provides current inventory
*       and the option to change or add (UPDATE)
*       - admin accessible, only
* 
*=====================================
*/


//INVENTORY!
//for loop to iterate through stock and add one for a blank line
//if line stays blank, don't enter it back in!!

include ('includes/header.html');
//require('../mysqli_connect.php');//requires database connection

if(!isset($_SESSION['userAccess'])){
        exit('You have accessed this page in error');
}
require('../mysqli_connect.php');//requires database connection
    
if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Handle the form.

    //turn off sql autocommit
    mysqli_autocommit($dbc, FALSE);
    //if new item check
    if(!empty($_POST['quantNew'])){
        $desNew = mysqli_real_escape_string($dbc, trim($_POST['descNew']));
        if(is_numeric($_POST['wgtNew'] && $_POST['priceNew'] && $_POST['quantNew'])){
            $wgtNew = mysqli_real_escape_string($dbc, trim((int)$_POST['wgtNew']));
            $prcNew = mysqli_real_escape_string($dbc, trim((float)$_POST['priceNew']));
            $qntNew = mysqli_real_escape_string($dbc, trim((int)$_POST['quantNew']));




        }else{
            echo '<div class="errors">Please use numeric values only!</div>';
        }
    }
    //if updated fields
    if(!empty($_POST['prod'])){
        echo 'woo';
        $q = "UPDATE t_stock SET descrip=?, price=?, avail=? pieceWgt=?
                WHERE prodID=".$_POST['prod'];
        //prepare update for fields
        $stmt = mysqli_prepare($dbc, $q);
        mysqli_stmt_bind_param($stmt, 'sidi', $des, $wgt, $prc, $qnt);
        $des = mysqli_real_escape_string($dbc, trim($_POST['desc']));
        if(is_numeric($_POST['wgt'] && $_POST['price'] && $_POST[$avl])){
           
            $wgt = mysqli_real_escape_string($dbc, trim((int)$_POST[$weight]));
            $prc = mysqli_real_escape_string($dbc, trim((float)$_POST[$price]));
            $qnt = mysqli_real_escape_string($dbc, trim((int)$_POST['quant']));
            mysqli_stmt_execute($stmt);
            //$yes = mysqli_stmt_affected_rows($stmt);
            
            



        }else{
                echo 'Please use numeric values only!';
        }
    }
}
?>  
    
    <h1>Update Inventory</h1>
        <p class="salut"><em>Modify or add stock to the inventory.</em></p>
 <?php   
    $q = 'SELECT * FROM t_stock ORDER BY prodID';
    $r = mysqli_query ($dbc, $q);
    $num = mysqli_num_rows($r);
    if(mysqli_affected_rows($dbc) == 0) {
        echo '<p class="error">Problems accessing database</p>';

    }elseif(mysqli_num_rows($r)>0) { // If it ran OK, display the records.
        echo '<form id="stock" action = "" method = "post">';
        //establish entry fields
        echo '<table id="stocklist" border="border">
            <tr>
                <th> Product ID </th>
                <th> Description </th>
                <th> Weight (lb.) </th>
                <th> Price $ </th>
                <th> Quantity </th>
            </tr>';
        $i=0;
        while($row = mysqli_fetch_array($r, MYSQLI_NUM)){
            $id=$row[0];
            $descr=$row[1];
            $price=$row[2];
            $avl=$row[3];
            $weight=$row[4];
            ?>
           <tr>
                <td><?php echo $id?><input type="hidden" name="prod" id="prod<?php echo $i?>"
                    value="<?php echo $id?>" /></td>
                <td><label for="desc<?php echo $i?>"><input type="text" name="desc" id="desc<?php echo $i?>"
                    size="50" maxlength="150" value="<?php if (isset($descr)) echo $descr; ?>" /></td>
                <td><label for="wgt<?php echo $i?>"><input type="text" name="wgt" id="wgt<?php echo $i?>"
                    size="4" maxlength="2" value="<?php if (isset($weight)) echo $weight; ?>" /></td>
                <td><label for="price<?php echo $i?>"><input type="text" name="price" id="price<?php echo $i?>"
                    size="6" maxlength="6" value="<?php if (isset($price)) echo $price; ?>" /></td>
                <td><label for="quant<?php echo $i?>"><input type="text" name="quant" id="quant<?php echo $i?>" 
                    size ="4" maxlength="4" value="<?php if (isset($avl)) echo $avl; ?>" /> </td>
                </tr>
         <?php       
                $i++;
        }
        $i++; //next prod id
    }
?>
        <tr>
            <td><?php echo $i ?>: New item</td>
            <td><label for="descNew$i"><input type="text" name="descNew" id="descNew"
                size="50" maxlength="150"  /></td>
            <td><label for="wgtNew$i"><input type="text" name="wgtNew" id="wgtNew"
                size="4" maxlength="2"  /></td>
            <td><label for="priceNew$i"><input type="text" name="priceNew" id="priceNew"
                size="6" maxlength="6"  /></td>
            <td><label for="quantNew$i"><input type="text" name="quantNew" id="quantNew" 
                size ="4" maxlength="4"  /> </td>
            </tr>
        
        </table>
            <p id="invent">
            <input type="submit"  value="Update" /> 
            </p>
              </form>
           
<?php        
include ('includes/footer.html');
?>