<?php include 'includes/sessioncookie.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>CheckOut</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="./bootstrap/css/overides.css"/>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script type=text/javascript src="javaSript.js"></script>
  <script src="./bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
    


<div class="container-fluid">
     <?php 
       
       include 'includes/header_select.inc.php';
     ?>
    
     <?php
     $fname = $lname = $phone = $email = $sfname = $slname = $sphone = $semail = "";
     $add = $city = $state = $zip = $sadd = $scity = $sstate = $szip = "";
     $cnum = $cmon = $cyear = "";
     if(isset($_POST['checkoutsubmit']))
     {
    
         $servername = "localhost";
         $username = "root";
         $password = "";
         $dbname = "azteka";

         // Create connection
        $conn = new mysqli($servername, $username, $password,$dbname);

         // Check connection
       if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
           }
           
        $cookievalue = $_COOKIE['AZTEKA'];
	 $id = explode( ',', $cookievalue )[0];
         date_default_timezone_set("America/Los_Angeles"); 
         $orderno = $id."_".date('mdHi');
         $cartval = $_COOKIE['AZCART'.$id];
         $eachitem = explode('||',$cartval);
          $updatesold = 0;
         foreach($eachitem as $i)
         {
             $isbn = explode(',',$i)[0];
             $qty = explode(',',$i)[1];
          
             $sql = "SELECT sold from books WHERE ISBN = '$isbn'";
             $result = $conn->query($sql);
            
             if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                 $updatesold = $row["sold"] ;
                 $updatesold = intval($qty)+intval($updatesold);
              }
             }
             
             $sql = "UPDATE books SET sold=$updatesold  WHERE isbn = '$isbn'";
             $conn->query($sql);
         }
          setcookie('AZCART'.$id, '',1,'/');
          unset($_COOKIE['AZCART'.$id]);
       
         echo "<div id = \"confirm\">";
         echo "<span>Hello there</span>";
         echo "<p>Your Order is placed Successfully. The order details are sent to your mail. Please Let us know if you feel any discrepancies with your Order Information.We are happy to help you.Your Shipping may take from 1 to 2 days.Please inform before shipping.</p>";
         echo "<p>Order Number:&nbsp;$orderno<p>";
         echo "</div>";
         include 'includes/footer.inc.php';
         setcookie('AZTEKA', '',1,'/'); // empty value and old timestamp
         unset($_COOKIE['AZTEKA']);
         
         return; 
        
       
    }

       ?>

     
       
       <form role="form" id="checkoutform" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
           
	<div class="control-group">

<div class="controls form-group-sm">
  <div id="billing">
            <p id="billinginfo">Billing Information</p>
<div class="row">
<div class="col-sm-2">
<div class="form-group">
    <label for="fname">First Name</label>
    <input type="text" class="form-control" id="fname" name="fname" value = "<?php  echo $fname; ?>">
  </div>
</div>
<div class="col-sm-2">
<div class="form-group">
    <label for="lname">Last Name</label>
    <input type="text" class="form-control" id="lname" name="lname" value = "<?php  echo $lname; ?>">
  </div>
</div>
    
<div class="col-sm-2">
<div class="form-group">
    <label for="phone">Mobile</label>
    <input type="phone" class="form-control" id="phone" name="phone" value = "<?php  echo $phone; ?>">
  </div>
</div>
    
<div class="col-sm-3">
<div class="form-group">
    <label for="email">Email</label>
    <input type="email" class="form-control" id="email" name="email" value = "<?php  echo $email ?>">
  </div>
</div>
    
    
</div>
    <div class="row">
<div class="col-sm-4">
<div class="form-group">
    <label for="add">Address</label>
    <input type="text" class="form-control" id="address1" name="add" value = "<?php  echo $add; ?>">
  </div>
</div>

<div class="col-sm-2">
<div class="form-group">
    <label for="City">City</label>
    <input type="text" class="form-control" id="city" name="city" value = "<?php  echo $city; ?>">
  </div>
</div>
<div class="col-sm-1">
<div class="form-group">
    <label for="state">State</label>
    <input type="text" class="form-control" id="state" name="state"value = "<?php  echo $state; ?>">
  </div>
</div>
<div class="col-sm-2">
<div class="form-group">
    <label for="zip">ZipCode</label>
    <input type="text" class="form-control" id="zip" name="zip"value = "<?php  echo $zip; ?>">
  </div>
</div>
</div>
    
</div>

  <div id="shipping">
            <p id="shippinginfo">Shipping Information</p>
            
 <div class="row">
<div class="col-sm-7">
<div class="form-group">
     <div class="checkbox">
     <label><input type="checkbox" id="chk" value="">Same as Billing address</label>
     </div>
  </div>
</div>
 </div>    
<div class="row">
<div class="col-sm-2">
<div class="form-group">
    <label for="fname">First Name</label>
    <input type="text" class="form-control" id="sfname" name="sfname" value = "<?php  echo $sfname; ?>">
  </div>
</div>
    
<div class="col-sm-2">
<div class="form-group">
    <label for="lname">Last Name</label>
    <input type="text" class="form-control" id="slname" name="slname" value = "<?php  echo $slname; ?>">
  </div>
</div>
    
<div class="col-sm-2">
<div class="form-group">
    <label for="phone">Mobile</label>
    <input type="phone" class="form-control" id="sphone" name="sphone" value = "<?php  echo $sphone; ?>">
  </div>
</div>
    
<div class="col-sm-3">
<div class="form-group">
    <label for="email">Email</label>
    <input type="email" class="form-control" id="semail" name="semail" value = "<?php  echo $semail; ?>">
  </div>
</div>
    
    
</div>
    <div class="row">
<div class="col-sm-4">
<div class="form-group">
    <label for="add">Address</label>
    <input type="text" class="form-control" id="saddress1" name="sadd" value = "<?php  echo $sadd; ?>">
  </div>
</div>

<div class="col-sm-2">
<div class="form-group">
    <label for="City">City</label>
    <input type="text" class="form-control" id="scity" name="scity" value = "<?php  echo $scity; ?>">
  </div>
</div>
<div class="col-sm-1">
<div class="form-group">
    <label for="state">State</label>
    <input type="text" class="form-control" id="sstate" name="sstate" value = "<?php  echo $sstate; ?>">
  </div>
</div>
<div class="col-sm-2">
<div class="form-group">
    <label for="zip">ZipCode</label>
    <input type="text" class="form-control" id="szip" name="szip" value = "<?php  echo $szip; ?>">
  </div>
</div>
</div>
    
</div>

 <div id="card">
            <p id="cardinfo">Credit Card Information</p>
            
 
<div class="row">
<div class="col-sm-2">
 <div class="form-group">
  <label for="card">Card Type</label>
  <select class="form-control" id="ctype" name = "ctype" value = "<?php  echo $ctype; ?>">
      <option value="so">Select One</option>
    <option value="ae">American Express</option>
    <option value="mc">Master Card</option>
    <option value="vc">Visa Card</option>
    <option value="o">Other</option>
  </select>
</div>
</div>
    
<div class="col-sm-3">
<div class="form-group">
    <label for="lname">Card Number</label>
    <input type="password" class="form-control" id="cnum1" name="cnum1"  value = "<?php  echo $cnum; ?>">
  </div>
</div>
    

<div class="col-sm-2">
<div class="form-group">
    <label for="expm">Expiration Month</label>
    <input type="text" class="form-control" id="mm" name="cmon" placeholder="MM" value = "<?php  echo $cmon; ?>">
  </div>
</div>
    
<div class="col-sm-2">
<div class="form-group">
    <label for="expy">Expiration Year</label>
    <input type="text" class="form-control" id="yy" name="cyear" placeholder="YYYY" value = "<?php  echo $cyear; ?>">
  </div>
</div>
    

    
    
</div>
   
    
</div>

       
   <div class="col-sm-10">
      <div class="form-group register">
  
  <a href ="member.php"><button class="btn btn-default">Back</button></a>
 <button type="submit" class="btn btn-default" id="checkoutsubmit" name = "checkoutsubmit">Place Order</button>
 <button type="reset" class="btn btn-default">Reset</button> 

      </div>
  </div>   
    <div id="vmsg"></div>		    
           
            </div>
            </div>
     
   
      
        </form>
   	    		
</div>
    
     <?php include 'includes/footer.inc.php';
     $_SESSION["timeout"] = time();
     ?>
    </body>
</html>