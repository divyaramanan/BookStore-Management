<?php include 'includes/sessioncookie.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Admin</title>
  <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="./bootstrap/css/overides.css"/>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script type=text/javascript src="javaSript.js"></script>
  <script src="./bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
    

<div class="container-fluid">
  
  
 <?php include 'includes/header_select.inc.php';
 ?>
    
 <?php
   $emailErr="";
   $user="";
   $levelto="";
   $promotedecision="";
   $name="";
   $prresult="";
    if(isset($_POST['submit']))
    {
      $_SESSION["timeout"] = time();
       $email = $_POST["email"];
     
         
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "azteka";
$validemail="";
$user="";
         
// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
  
$sql = "SELECT users.Email,users.promotion,users.userlevel,enroll.Name FROM users,enroll WHERE users.Email = '$email' AND users.Email = enroll.email";

        
$result = $conn->query($sql);
$levelArray=array("member","Author","Publisher","Admin");
$promoteArray = array("Interested","Not Interested","Do not Know");
$dbinterestArray = array("Yes","No","NotYet");

if ($result->num_rows > 0) {
    // output data of each row
     $_SESSION["timeout"] = time();
    while($row = $result->fetch_assoc()) {
         $_SESSION["timeout"] = time();
        $level = $row["userlevel"];
        if($level!="Admin")
        {
        $name = $row["Name"];
        $user = $row["Email"];
        $promotion = $row["promotion"];
        $promoteidx = array_search("$promotion",$dbinterestArray);
        $promotedecision = $promoteArray[$promoteidx];
         $levelidx = array_search("$level",$levelArray);
        $levelto = $levelArray[$levelidx+1]; 
         $validemail="yes";
     
        }
       else {
         $user = $row["Email"];
        $emailErr = "*User is an Admin. No promotion possible";
       
        
       }
    }
} 
else{
  
  $emailErr = "*User Not Found"; 
 
 
}

$conn->close();   
     }
   
   
   function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}

    
    
?>
<?php

if(isset($_POST['promotesubmit']))
{
  $_SESSION["timeout"] = time();
  $validemail ="yes";
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "azteka";
  $conn = new mysqli($servername, $username, $password,$dbname);
  $levelto = $_POST['hiddenlevelto'];
  $user = $_POST['hiddenemail'];
  $name = $_POST['hiddenname'];
  $promotedecision = $_POST['hiddendesc'];
  
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

 $sql = "UPDATE users SET userlevel='$levelto',promotion='NotYet' WHERE Email = '$user'";
 $conn->query($sql);
 
 $conn->close();  
 $prresult = "User Successfully Promoted";
}

?>
   <p id="admin">Welcome Admin!!<br/>
        <span>You may now Change the User level using User &#39;s Email Id.</span></p>

   <div id="contain">
  <div class="useremail">
      <form role="form" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post" id="adminform">    
  <div class="form-group">
    <label for="email">Email address:</label>
    <input type="text" class="form-control focusedInput" id="useremail" placeholder="xyz@somedomain.com" name="email" value = "<?php echo $user; ?>">
    <input type="text" id="hideuserbox" value="<?php echo $validemail; ?>" hidden="">
  </div>
  <button type="submit" class="btn btn-default" id="adminSubmit" name="submit">Submit</button>
  <button type="reset" class="btn btn-default">Reset</button>
  <div id="erroradmin"><?php echo $emailErr; ?></div>
 </form>
    
  
</div>
   <div class="userdetails">
     
       <p> User Name:&nbsp; <span><?php echo $name?></span></p>
       <p> User Email:&nbsp; <span><?php echo $user?></span></p>
       <p>  Interested in Promotion: &nbsp;<span><?php echo $promotedecision?></span></p>
       <p>   Promotion To: &nbsp; <span><?php echo $levelto?></span></p>
       
       <form role="form" method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
        <input type="text" name="hiddenemail" value="<?php echo $user; ?>" hidden>
        <input type="text" name="hiddenlevelto" value="<?php echo $levelto; ?>" hidden>
        <input type="text" name="hiddenname" value="<?php echo $name; ?>" hidden>
         <input type="text" name="hiddendesc" value="<?php echo $promotedecision; ?>" hidden>
        <input  type="submit" class="btn btn-default" value="Promote" name="promotesubmit"><div id="promoteresult"><?php echo $prresult; ?></div>
       </form>
       
   </div>
   </div>
</div>
    <?php include 'includes/footer.inc.php';
     $_SESSION["timeout"] = time();
     ?>
</body>
</html>