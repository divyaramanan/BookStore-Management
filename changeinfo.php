<?php include 'includes/sessioncookie.php'; ?>

<?php
if(!isset($_COOKIE['AZTEKA'])) {
$url = "index.php";
header("Location: $url");
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Change Login Information</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
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
     <?php include 'includes/header_select.inc.php';
     ?>
    
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



$id =  explode( ',', $_COOKIE['AZTEKA'])[0];
$sql = "SELECT users.Email,enroll.question,enroll.answer,users.promotion FROM users,enroll WHERE id=$id AND users.Email = enroll.email";
$result = $conn->query($sql);
$pass="";


$status="";
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $email = $row["Email"];
        $quest = $row["question"];
        $ans = $row["answer"];
        $promote = $row["promotion"];
     
    }
}
if(isset($_POST['changesubmit']))
{
     if(!empty($_POST["rpass"]))         
     {
         $rpass = $_POST["rpass"];
         $sql = "UPDATE users SET password = sha1('$rpass') WHERE Email = '$email'";
         $conn->query($sql);
     }
     $squestion = $_POST["quest"];
     $sanswer = $_POST["ans"];
     $ipromotion = $_POST["optradio"];
     $securitysql = "UPDATE enroll SET question = '$squestion',answer = '$sanswer' WHERE Email = '$email'";
     $conn->query($securitysql);
     
     $promotesql = "UPDATE users SET promotion='$ipromotion'  WHERE Email = '$email'";
     $conn->query($promotesql);
     $status="Information Saved Successfully";
     
   
}
$conn->close();
   
   ?>
     <p class="headings">Hi there!!!<br/>
        <span>You may now Change the Login Information or Promotion Interests</span></p>
     <div id="emaillabel">Email:&nbsp;<?php echo $email; ?></div>
   <form role="form" id="changeform" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
           
	<div class="control-group">

<div class="controls form-group-sm">
 <div id="change">
            <input type="text" name="level" id="level" hidden value="<?php echo explode( ',', $_COOKIE['AZTEKA'])[1]; ?>">
 

<div class="col-sm-5">
<div class="form-group">
    <label for="rpass">Password</label>
    <input type="password" class="form-control" id="rpass" name="rpass" value="<?php echo $pass; ?>">
  </div>
</div>
     
<div class="col-sm-5">
<div class="form-group">
    <label for="repass">Retype Password</label>
    <input type="password" class="form-control" id="repass" name="repass" value="<?php echo $pass; ?>">
  </div>
</div>
     
 <div class="col-sm-10">
<div class="form-group">
    <label for="quest">Security Question</label>
    <input type="text" class="form-control" id="quest" name="quest" placeholder="What is my Dream destiny?" value="<?php echo $quest; ?>">
  </div>
</div>
     
 <div class="col-sm-5">
<div class="form-group">
    <label for="ans">Answer</label>
    <input type="password" class="form-control" name="ans" id="ans" value="<?php echo $ans; ?>">
  </div>
</div>
  

       
   <div class="col-sm-10">
      <div class="form-group changebuttons">
          
 <button type="submit" class="btn btn-default" id="changesubmit" name="changesubmit">Save</button>
  <button type="reset" class="btn btn-default">Reset</button>   
      </div>
  </div>
    <div id="promote">
            <div class="col-sm-7">
            <div class="form-group">
                <?php
                $leveltopromote="";
                $cookievalue = $_COOKIE['AZTEKA'];
		$level = explode( ',', $cookievalue )[1];
                if($level!="Admin")
                {
                    $levelArray=array("member","Author","Publisher","Admin");
                    $levelidx = array_search("$level",$levelArray);
                    $leveltopromote = $levelArray[$levelidx+1]; 
                }
                ?>
                <label for="promotion">Wish To be Promoted To&nbsp;<?php echo $leveltopromote; ?>?</label>
            <div class="radio">
               <label><input type="radio" name="optradio" value="Yes"  <?php if($promote=="Yes"){echo "checked";}?>>Yes</label>
            </div>
            <div class="radio">
             <label><input type="radio" name="optradio" value="No"  <?php  if($promote=="No"){echo "checked";} ?>>No</label>
            </div>
            <div class="radio">
                <label><input type="radio" name="optradio" value="NotYet"  <?php  if($promote=="NotYet"){echo "checked";} ?>>Not Now</label>
            </div>
            </div>
            </div>
            </div>
     </div>      
            </div>

            </div>
       
                     </form>
     <div id="changestatus"><?php echo $status; ?></div>
     </div>
   
      
    		    		

     <?php include 'includes/footer.inc.php';
     $_SESSION["timeout"] = time();
     ?>
    </body>
</html>