<?php
if(!isset($_COOKIE['AZTEKA']))
{
if(!isset($_COOKIE['mainpage']))
{
  setcookie("mainpage",1, time() + (86400 * 30), "/"); 
  
}
else 
{
 $visit = $_COOKIE['mainpage'];
 $visit = $visit + 1;
  setcookie("mainpage",$visit, time() + (86400 * 30), "/");
}
}

if(!isset($_COOKIE['SORT'])){
  setcookie("SORT","none", time() + (86400 * 30), "/");     
}
?>

<?php include 'includes/lastaccess.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Azteka Book Corporation</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="./bootstrap/css/overides.css"/>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script type=text/javascript src="javaSript.js"></script>
    <script type=text/javascript src="ajax_get_lib.js"></script>
  <script src="./bootstrap/js/bootstrap.min.js"></script>
</head>
<body id="mainbody">



<div class="container-fluid">
     <?php 
     include 'includes/header_select.inc.php';
    
     ?>
    
       
    
   <div id="myCarousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
    <li data-target="#myCarousel" data-slide-to="3"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item active">
        <img src="images/teen.jpg" alt="Chania">
    </div>

    <div class="item">
        <img src="images/biographies.jpg" alt="Chania">
    </div>

    <div class="item">
        <img src="images/life.jpg" alt="Flower">
    </div>

    <div class="item">
        <img src="images/children.jpg" alt="Flower">
    </div>
  </div>

  <!-- Left and right controls -->
  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div> 
     <?php
   $indexErr="";
   $email="";
   $cmd="";
   
    if(isset($_POST['indexsubmit']))
    {
     
                      
            $email = $_POST["login"]; 
            $indexpassword = $_POST["indexpassword"]; 
            $servername = "localhost";
            $username = "root";
            $password="";
            $dbname = "azteka";


         
          // Create connection
          $conn = new mysqli($servername, $username, $password,$dbname);
          // Check connection
          if ($conn->connect_error) {
               die("Connection failed: " . $conn->connect_error);
           }
  
              $sql = "SELECT id,password,userlevel FROM users WHERE Email = '$email'";

        
              $result = $conn->query($sql);


             if ($result->num_rows > 0) {
                       // output data of each row
    
                     while($row = $result->fetch_assoc()) {
                           if(sha1($indexpassword)==trim($row["password"]))
                            {
                            
                            $cmd = $row["userlevel"];
                            $cookieval = $row["id"].",".$cmd;
                            setcookie("AZTEKA",$cookieval,NULL, "/");
                            session_start(); 
                            $_SESSION["timeout"] = time();
                            
                            $cart = "empty";
                            $cartname = "AZCART".$row["id"];
                            if(!isset($_COOKIE[$cartname])) {
                               setcookie($cartname,$cart, time() + (86400 * 30), "/");
                                }
                              
                            
                             $visit = $_COOKIE['mainpage'];
                             
                             setcookie("mainpage",$visit, time() + (86400 * 30), "/");
                            
                            $email="";
                            $cmd = strtolower($cmd).".php";
                            $home = "index.php";
                            header("Location: $home");
                            }
                           else {
                            $indexErr = "Invalid password";
                           }
                           }
                       } 
            else{
                $indexErr = "User Not registered";  
                }

            $conn->close();
            
     
   
}  
    ?>
  <div id="form-contain">
 <form role="form" method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" id="firstlogin">
     <div class="form-group">
    <label id="login" name="login">User Login</label>
  </div>
  <div class="form-group">
    <label for="email">Email address:</label>
    <input type="text" class="form-control focusedInput" id="email" name="login" value="<?php echo $email; ?>">
  </div>
  <div class="form-group">
    <label for="pwd">Password:</label>
    <input type="password" class="form-control" id="pwd" name="indexpassword">
  </div>
  <div id="errorindex"><?php echo $indexErr; ?></div>
  <button type="submit" class="btn btn-default" name="indexsubmit" id="indexsubmit">Submit</button>
  <button type="reset" class="btn btn-default">Reset</button>
 
  <input type="text" id="hiddenfld" value="<?php echo $cmd; ?>" hidden/>
</form> 
       <a href ="forgot.php" class="forgotpass">Forgot Password?</a>
  </div> 

</div>
    
 <div class="container">
     <p>Our Collections</p>
     
     <div class="row sort">
<div class="col-sm-3">
 <div class="form-group">
  
  <select class="form-control" id="sortorder" name = "sortorder" >
      <option value="sort">Choose a Sort Order</option>
    <option value="isbn">Sort by ISBN</option>
    <option value="price">Sort by Price</option>
    <option value="title">Sort by title</option>
    <option value="author">Sort by Author name</option>
  </select>
  
</div>
</div>
     </div>
  
     <div class="row fetchbooks" id="displaybooks">
    
   <?php 
   $servername = "localhost";
$username = "root";
$password = "";
$dbname = "azteka";
$cartval = "";
// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_COOKIE['AZTEKA'])){
        $cookievalue = $_COOKIE['AZTEKA'];
	$id = explode( ',', $cookievalue )[0];
        $cartname = "AZCART".$id;
        if(isset($_COOKIE['AZCART'.$id]))
              {
        $cartval = $_COOKIE[$cartname];
              }
        //$cartarray = explode( '||', $cartval );
                
    }
  if(isset($_COOKIE['AZTEKA']))
   {
      $_SESSION["timeout"] = time();  
   }  

   $page = "";
   
   if(isset($_GET['page']))
   {
       $page = $_GET['page'];
   }
    
    if($page == "" || $page == "1")
    {
        $page1 = 0;
    }
    else
    {
        $page1 = ($page*8)-8;
    }
    if(isset($_COOKIE['AZTEKA']))
   {
      $_SESSION["timeout"] = time();  
   }
    

$sql = "SELECT * FROM books WHERE status = 'Publish'";

if(isset($_COOKIE['SORT']))
{
  $sortorder = $_COOKIE['SORT'];

switch ($sortorder) {
    case "isbn":
        $sql = "SELECT * FROM books WHERE status = 'Publish' ORDER BY ISBN ASC";
        break;
    case "price":
        $sql = "SELECT * FROM books WHERE status = 'Publish' ORDER BY Price ASC";
        break;
    case "author":
        $sql = "SELECT * FROM books WHERE status = 'Publish' ORDER BY Author ASC";
        break;
    case "title":
        $sql = "SELECT * FROM books WHERE status = 'Publish' ORDER BY Title ASC";
        break;
     default:
         $sql = "SELECT * FROM books WHERE status = 'Publish'";
}
}
 $limitsql = $sql ." limit $page1,8";
 
$result = $conn->query($limitsql);
$idno = 1;
if ($result->num_rows > 0) {
    
   if(isset($_COOKIE['AZTEKA']))
   {
      $_SESSION["timeout"] = time();  
   }
    
    
    if(isset($_COOKIE['AZTEKA']))
   {
      $_SESSION["timeout"] = time();  
   }
    while($row = $result->fetch_assoc()) {
        $image = $row["Photo"];
        $title = $row["Title"];
        $author = $row["Author"];
        $isbn = $row["ISBN"];
        $price = $row["Price"];
        $show = $row["show_img"];
        $thumbimg = $isbn.".jpg";
        $isbnpattern = "/$isbn/";
     echo "<div class=\"col-sm-3\">"; 
     echo "<figure class=\"cap-bot\">";
     if($show == "teaser")
     {
     echo "<img class=\"thumbnailpic\" src=\"thumbnail/$thumbimg\" alt=\"test\"/><br/>";
     echo "<span>$title</span>";
     }
    else {
    echo "<img  class=\"normalpic\" src=\"images/$image\" alt=\"test\"/>"; 
     }
     
     echo "<figcaption>$title<br/><br/>Author:&nbsp;$author<br/><br/>ISBN:&nbsp;$isbn<br/><br/>Price:&nbsp;$$price<br/><br/>"; 
    
        echo "<a href=\"moredetails.php?isbn=$isbn&&idno=$idno\"><button class=\"btn btn-default\">More Details</button></a>";
    
     echo "</figcaption></figure></div>"; 
    }
    
} 


 $result1 = $conn->query($sql);
 $pagecount = ceil($result1->num_rows/8);
   
    if(isset($_COOKIE['AZTEKA']))
   {
      $_SESSION["timeout"] = time();  
   }

    $conn->close(); 
 
   ?>
  
  </div>
</div>
    
    <?php
    
    echo "<ul id=\"pages\" class=\"pagination\">";
for($a= 1; $a<=$pagecount;$a++)
    {
    ?>  <li> <a  href = "index.php?page=<?php echo $a?>"> <?php echo $a." "; ?> </a></li> <?php
    }
   echo "</ul>"; 
    
    ?>
     <?php include 'includes/footer_index.inc.php';
   if(isset($_COOKIE['AZTEKA']))
   {
      $_SESSION["timeout"] = time();  
   }
     ?>
   
</body>
</html>
