<?php # Script 17.7 - post.php
// This page order form request method
// this may need header/footer attached as it's its own basepage - then with a login link back to home/index


require('../mysqli_connect.php');//requires database connection - KILL AT WORK

if(isset($_SESSION['errors'])) {
        unset($_SESSION['errors']);
        }
// purchase function for all the math handling...        
function chocPurchase($dbc, $prodID= '', $quant=''){
    $q = "SELECT * FROM t_stock WHERE prodID = $prodID";
    $r = mysqli_query($dbc, $q);
    if (mysqli_num_rows($r) == 1) {
        $price = $row['price'];
        $avail = $row['avail'];
        $wgt = $row['pieceWgt'];
        $num = $avail - $quant;
        //if not ample inventory, generate backorder amount
        if($num < 0){
            for($x=0; $x<=$avail; $x++){
                $restock = $x;
            }
            //backordered
            $bkOrd = $quant - $restock;
            //in stock
            $shortNum = $quant - $bkOrd;
            $volCost = $shortNum * $price;
            $shipWgt = $shortNum * $wgt;
            
        }else{
            $bkOrd = 0;
            $shortNum = $quant;
            $volCost = $shortNum * $price;
            $shipWgt = $shortNum * $wgt;
            
        }
        //update inventory in t_stock
        $q = "UPDATE t_stock SET avail=avail-$shortNum WHERE prodID=$prodID LIMIT 1";
        //if database updated correctly, return math order values
        if(mysqli_affected_rows($dbc)==1){
            return $ordItemDtls = array($bkOrd, $shortNum, $volCost, $shipWgt);
            
        }else{
            return $_SESSION['errors']['database'] = 'System error. Unable to access inventory for order.';
        } //end database array return
    }
}//end chocPurchase function

include ('includes/header.html'); //included for page title to work

        
if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Handle the form.
    //validate matching password to process
    
    
    
if(filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)){
    $pass = mysqli_real_escape_string($dbc, trim($_POST['pass2']));
    $email = mysqli_real_escape_string($dbc, trim($_POST['email']));    
    
    $fName = mysqli_real_escape_string($dbc, trim($_POST['fName']));
    $lName = mysqli_real_escape_string($dbc, trim($_POST['lName']));
    $addr = mysqli_real_escape_string($dbc, trim($_POST['addr']));
    $town = mysqli_real_escape_string($dbc, trim($_POST['town']));
    $steCode = mysqli_real_escape_string($dbc, trim($_POST['steCode']));
    $zip = mysqli_real_escape_string($dbc, trim($_POST['zip']));
            
            
    //declare array of all purchase details
    //$_SESSION['ordDtls'] = array(); ONLY NEED IF I USE WHILE LOOP
    $q = "SELECT * FROM t_stock";
    $r = mysqli_query($dbc, $q);
    $num = mysqli_num_rows($r);
    //iterate through potential order fields to declare values for purchase
    $tlCost = 0;
    $tlWgt = 0;
    for($i=1; $i<=$num; $i++){
        if($_POST[$i] != '' && filter_var($_POST[$i], FILTER_VALIDATE_INT, array('min_range'=>1)) ){
            $prodID = $i;
            $_SESSION['prods'][] = $prodID;
            $quant = (int)$_POST[$i];
            $_SESSION['quants'][] = $quant;  //array_sum($_SESSION['quants']) for total
            list($bkOrd, $shortNum, $volCost, $shipWgt)=chocPurchase($prodID, $quant);
            if(isset($_SESSION['errors']['database'])){
                echo 'Apologies - '.$_SESSION['errors']['database'];
                exit();
            }else{
            $_SESSION['bkOrds'][] = $bkOrd;
            $_SESSION['shortNums'][] = $shortNum;
            $tlCost+=$volCost;
            $tlWgt+=$shipWgt;
            } 
        }//end if $POST field conditional 
    } //end for loop
} //end email filter check

 
echo '<h3>Thank you, $_POST["fName"] $_POST["lName"]!</h3>
        <h3>Here are the details of your order:</h3>';
$iter=0;
foreach($_SESSION['quants'] as $qnt){ //IF THIS ALL DOESN'T WORK WELL - MAKE A WHILE LOOP (PG649!)
    echo "<div class='receipt'>
        <p>Quantity: ".$qnt;
    foreach($_SESSION['prods'] as $pid){ //array($prodID=>array($bkOrd, $shortNum, $volCost, $shipWgt))
        $q = "SELECT descrip, price, pieceWgt FROM t_stock WHERE prodID=$pid";
        $r = mysqli_query($dbc, $q);
        if (mysqli_num_rows($r) == 1) {
            echo $row['descrip']." (".$row['pieceWgt'].") at $".$row['price'];
            foreach($_SESSION['shortNums'] as $shyNum){
                if($shyNum != $qnt){
                    echo '<br/>Apologies - only '.$shyNum.' in stock to ship.';
                    foreach($_SESSION['bkOrds'] as $bOrd){
                        echo $bOrd.' unit(s) back-ordered.
                            <br/>You will be billed the difference when your order if fulfilled.';
                        $bOrdP = number_format($bOrd*$row['price'],2);
                    }//end loop bkorder 
                }//end if difference
            }//end loop shortstock  
        }//end if row returned
    }//end loop prodid
    //INSERT QUERY WILL GO HERE!!!!!! t_orderDetails
}//end loop quant
echo '</p>';
echo "<p>
    Purchase total before shipping/handling: $".number_format($tlCost,2).
    "<br/>Total ship weight for this order: ".$tlWgt." lb(s).<br/>";
switch (true) {
    case ($tlWgt<=2):
        $ship = 5.00;
        echo "Shipping: $".$ship;
        break;
    case ($tlWgt>2 && $tlWgt<=5):
        $ship = 7.00;
        echo "Shipping: $".$ship;
        break;
    case ($tlWgt>5 && $tlWgt<=8):
        $ship = 9.00;
        echo "Shipping: $".$ship;
        break;
    default:
        $ship = 12.00;
        echo "Maximum shipping: $".$ship;  
}
$ttlPrice = $tlCost+$ship;
echo "<br/>Total cost, with shipping: $".number_format($ttlPrice,2)
        ."</p>
            </div>"; //end receipt class
    
echo "<div class='shipAddr'>
    <h3>Your shipping information:</h3>";

    //redisplay the form but with all fields uneditable and repeated from before:
?>

    <table id='confirm'>
        <tr>
          <td> <input type="text"  name="fName" id="fName" size="30"
                     value ="<?php echo $fName; ?>" readonly />
          </td>
          <td> <input type="text"  name="lName" id="lName" size="30" 
                     value ="<?php echo $lName; ?>" readonly />
          </td>
        </tr>
        <tr>
          <td> <input type="text"  name="addr" id="street" size="30" 
                     value ="<?php echo $addr; ?>" readonly />
          </td>
        </tr>
        <tr>
          <td> <input type="text"  name="town" id="city" size="30" 
                     value ="<?php echo $town; ?>" readonly />
          </td>
        </tr>
        <tr>
          <td> <input type="text"  name ="steCode" id="state" size="2" 
                     value ="<?php echo $steCode; ?>" readonly />
          </td>
        </tr>
        <tr>
          <td> <input type="text"  name="zip" id="zip" size="5" 
                     value ="<?php echo $zip; ?>" readonly />
          </td>
        </tr>
        <tr>
          <td> <input type="text"  name="email" id="email" size="30" 
                     value ="<?php echo $email; ?>" readonly />
          </td>
        </tr>
      </table>
</div> <!-- end shipAddr div -->





  <!-- The radio buttons for the payment method -->
        <h3> Payment Method: </h3>
        <p>
          <input type = "radio"  name = "payment" id="payment"  value = "visa"
                 checked = "checked" /> Visa 
          <input type = "radio"  name = "payment"  id="payment" value = "mc" />
            Master Card 
          <input type = "radio"  name = "payment" id="payment"
                 value = "discover" /> Discover
          
          Account Number: <input type="input"  name="acctNum" id="acctNum"
                 value = "" />  <br/>
        </p>
  
  <!-- The submit and reset buttons -->
<p>
<?php
    echo '<div class="goodbye">
        <p>You are now logged out.<br />
        Please visit us again soon!</p>';
    }
//}
include("order.php");
include ('includes/footer.html'); //included for page title to work
?>