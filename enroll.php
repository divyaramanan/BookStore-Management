<?php if(!isset($_POST["fname"])) {
    $url = "register.php";
   header("Location: $url");
    
   }
   
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Enroll</title>
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
 <?php include 'includes/header_select.inc.php';
     ?>
    <div id="enroll">
    <div class="jumbotron">
      <div class="container">
        <h1>Hello, <?php echo $_POST["fname"];?></h1>
        
      
    
  
   <?php 
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

$name = $_POST["fname"]." ".$_POST["lname"];
$address = $_POST["add"].",".$_POST["city"].",".$_POST["state"].",".$_POST["zip"];
$email = $_POST["email"];
$question = $_POST["quest"];
$ans = $_POST["ans"];
$mobile = $_POST["phone"];
$land = $_POST["lphone"];
$pass = SHA1($_POST["rpass"]);
$userlevel = "member";
$promotion = "Notyet";




$stmt = $conn->prepare("INSERT INTO enroll(Name,Address,Mobile,Landline,email,question,answer)
VALUES(?,?,?,?,?,?,?)");
$stmt->bind_param("sssssss",$name,$address,$mobile,$land,$email,$question,$ans);

$resultenroll = $stmt->execute();

if ($resultenroll) {
    
    $result = $conn->query("SELECT MAX(id) AS max FROM users");
    if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    $id = $row["max"] + 1;
    }}
    else{
     $id=10000;
    }
       
$stmt2 = $conn->prepare("INSERT INTO users(id,Email,password,userlevel,promotion)
VALUES(?,?,?,?,?)");
$stmt2->bind_param("issss",$id,$email,$pass,$userlevel,$promotion);

$resultenroll2 = $stmt2->execute();

   
   if ($resultenroll2) {
       
       echo "<p>Thank You for Registering to Azteka.Your are now a Member in the Azteka Family. Login your credentials in the below link and Enjoy Our Classy and Amazing Novels of all Times!!!</p>";
       echo '<p><a class="btn btn-primary btn-lg" href="../projects/index.php" role="button">Login Now &raquo;</a></p>';
   
} else {
    echo "<p>Looks like there is an internal server Error. We apologise for the inconvienience.Please Try later</p>";
}
}
 else 
 {
    if(preg_match('/^Duplicate/s',$conn->error))
    {
        echo "<p>Looks like you have already been registerd to Us.Try  Registering to us using another Email Id or Use your old email id to login using the below link.<p>";
        echo '<p><a class="btn btn-primary btn-lg" href="../projects/index.php" role="button">Login Now &raquo;</a></p>';
    }
 else 
    {
       echo "<p>Looks like there is a problem in registering. We apologise for the inconvenience. Please try again. A gentle Reminder here, DO NOT use any quotes for your inputs.Thank You.<p>";  
    }
}



$conn->close();
   
   ?>
    
</div>
</div>
</div>
</div>
    <?php include 'includes/footer.inc.php';
     ?>
</body>
</html>