

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Forgot Password</title>
  <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="./bootstrap/css/overides.css"/>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script type=text/javascript src="javaSript.js"></script>
  <script src="./bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
    <script>
     window.onbeforeunload = function (e) {
            var e = e || window.event;
           

            // For IE and Firefox
            if (e) {
               
          window.history.replaceState({
                 foo: 'bar'
              }, 'Login', 'index.php');
            }

          
         };
    </script>

<div class="container-fluid">
  
  
 <?php include 'includes/header.inc.php';
 ?>
    
 <?php
   $emailErr="";
   $name="";
   $user="";
   $frresult="";
   $question="";
   
    if(isset($_POST['forgotsubmit']))
    {
     if(empty($_POST["email"])) {
    $emailErr = "*Email is required";    
    
   } else {
     $email = $_POST["email"];
     // check if e-mail address is well-formed
     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
       $emailErr = "*Invalid email format";   
 
     }
     else{
         
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "azteka";
$validemail="";
$email = $_POST["email"];
         
// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
  
$sql = "SELECT Name,email,question from enroll where email = '$email' ";

        
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    // output data of each row
    
    while($row = $result->fetch_assoc()) {
        
        
        
        $name = $row["Name"];
        $user = $row["email"];
        $question = $row["question"];
        
         $validemail="yes";
     
        
    }
} 
else{
  
  $emailErr = "*User Not Found"; 
 
 
}

$conn->close();   
     }
   }
   
   function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}

    
    }
?>
<?php

if(isset($_POST['securitysubmit']))
{
  $validemail ="yes";
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "azteka";
  $conn = new mysqli($servername, $username, $password,$dbname);  
  $user = $_POST['hiddenemail'];
  $name = $_POST['hiddenname'];
  $question = $_POST['hiddenquest'];
  $ans = $_POST['sanswer'];
  
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

 $sql = "SELECT users.id,users.userlevel FROM enroll,users WHERE enroll.email = '$user' AND enroll.answer = '$ans' AND users.Email = enroll.email";
 $result = $conn->query($sql);
 if ($result->num_rows > 0) 
     {
     
    while($row = $result->fetch_assoc()) {
     $cmd = $row["userlevel"];
     $cookieval = $row["id"].",".$cmd;
     setcookie("AZTEKA",$cookieval,NULL, "/");
     session_start(); 
     $url = "changeinfo.php";
     header("Location: $url");
     }
     }
 else{
    $frresult = "Incorrect Security Answer"; 
     }
 
 $conn->close();  
 
}

?>
   <p id="admin">Hi there!<br/>
        <span>Use this page to login using your Security answers</span></p>

   <div id="contain">
  <div class="useremail">
      <form role="form" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">    
  <div class="form-group">
    <label for="email">Email address:</label>
    <input type="email" class="form-control focusedInput" id="useremail" placeholder="xyz@somedomain.com" name="email" value = "<?php echo $user; ?>">
    <input type="text" id="hideuserbox" value="<?php echo $validemail; ?>" hidden="">
  </div>
  <button type="submit" class="btn btn-default" id="forgotSubmit" name="forgotsubmit">Submit</button>
  <button type="reset" class="btn btn-default">Reset</button>
  <div id="erroradmin"><?php echo $emailErr; ?></div>
 </form>
    
  
</div>
   <div class="userdetails">
     
       <p> Name:&nbsp; <span><?php echo $name?></span></p>
       <p> Email:&nbsp; <span><?php echo $user?></span></p>
       <p> Question: &nbsp;<span><?php echo $question?></span></p>
       <form role="form" method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
           <p> Answer: &nbsp; <input type="password" name="sanswer"/></p>
           <input type="text" name="hiddenemail" value="<?php echo $user; ?>" hidden>
           <input type="text" name="hiddenname" value="<?php echo $name; ?>" hidden>
           <input type="text" name="hiddenquest" value="<?php echo $question; ?>" hidden> 
        <input  type="submit" class="btn btn-default" value="Submit" name="securitysubmit"><div id="forgotresult"><?php echo $frresult; ?></div>
       </form>
       
   </div>
   </div>
    <?php include 'includes/footer.inc.php';
     ?>
</body>
</html>