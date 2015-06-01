<?php 
if(!(isset($_GET['isbn'])))
{
    return;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Azteka Member</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="./bootstrap/css/overides.css"/>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script type=text/javascript src="ajax_get_lib.js"></script>
   <script type=text/javascript src="javaSript.js"></script>
  <script src="./bootstrap/js/bootstrap.min.js"></script>
</head>
<body>



<div class="container-fluid">
     <?php include 'includes/header_select.inc.php';
     ?>
    <div id ="member">
     <p class="headings">More Details on the book</p>
    <?php
     $_SESSION["timeout"] = time();
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "azteka";
    $isbn = $_GET['isbn'];
    $idno = $_GET['idno'];
    $isbnpattern = "/$isbn/";
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
                
    }
     
    
         $sql = "SELECT * FROM books where ISBN = '$isbn'";
         $result = $conn->query($sql);
         
         if ($result->num_rows > 0) {
             
    // output data of each row
              $_SESSION["timeout"] = time();
    while($row = $result->fetch_assoc()) {
         $_SESSION["timeout"] = time();
        
        $image = $row["Photo"];
        $title = $row["Title"];
        $desc = $row["description"];
        $edition = $row["Edition"];
        $author = $row["Author"];
        $isbn = $row["ISBN"];
        $price = $row["Price"];
        $teaseimg = $isbn.".jpg";
         $show = $row["show_img"];
       
       if($show == "teaser")
       {
        echo "<img src=\"teaser/$teaseimg\" class=\"teaser\" alt=\"test\"/>";    
        }
     else {
      echo "<img  class=\"normalteaser\" src=\"images/$image\" alt=\"test\"/>"; 
       }
         echo "<div class=\"bookdetail\">";
        echo "<span class = \"specialbook\">$title</span><br/>";
        echo "<span>ISBN:</span>&nbsp;$isbn<br/>";
        echo "<span>Edition:</span>&nbsp;$edition<br/>";
        echo "<span>Price:</span>&nbsp;$price<br/>";
        echo "<span>Author:</span>&nbsp;$author<br/></td>";
        echo "<br/> <span>Description:</span><br/>";
        echo "$desc<br/><br/>";
        
        if($cartval != "")
       {
    if(preg_match($isbnpattern,$cartval))
    {
        echo "<a href=\"member.php\"><button  class=\" btnspl\">View in Cart</button></a>";
    }
    else
    {
     echo "<button class=\"cartadd btnspl\" id=\"cartbtnid$idno\" >Add to Cart</button>";
     echo "<input type=\"text\" id=\"cartinput$idno\" value=\"$isbn\" hidden>";
     $idno++;
    }
    }
    else{
      echo "<a href=\"index.php\"><button class=\"btnspl\">Login to add to cart</button></a>";
    }
      echo "</div>";  
        
    }
          
           
         
    }
    
     
    ?>
   
    </div>
        
   
    
</div>
     <?php include 'includes/footer.inc.php';
     $_SESSION["timeout"] = time();
     ?>
    </body>
</html>