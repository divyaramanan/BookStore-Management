<?php include 'includes/sessioncookie.php'; ?>

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
     <p id="abt">Member Cart</p>
    <?php
     $_SESSION["timeout"] = time();
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
    $cartname = "AZCART".$id;
    $cartval = $_COOKIE[$cartname];
    if($cartval == "empty")
    {
        
        echo "<div class=\"jumbotron cart\">";
        echo "<p align=\"left\">Your Cart looks empty. Browse our finest collections of books and order soon to experience the classies.You&#39;ll find a wonderfully stocked children&#39;s section filled with a wide variety of books from beloved classics to new favorites!
Our children&#39;s department also has fun and educational games, puzzles, and activity kits. </p>";
        echo " </div>";
         echo "<p><a class=\"btn btn-primary btn-lg\"  role=\"button\" id=\"startshopping\">Start Shopping &raquo;</a></p>";
    }
 else{
     $items = explode("||",$cartval);
     echo "<table>";
     $idno = 1;
     $final = 0;
     foreach($items as $i)
     {
          $_SESSION["timeout"] = time();
         $isbn = explode(",",$i)[0];
         $qty = explode(",",$i)[1];
         $sql = "SELECT * FROM books where ISBN = '$isbn'";
         $result = $conn->query($sql);
         
         if ($result->num_rows > 0) {
             
    // output data of each row
              $_SESSION["timeout"] = time();
    while($row = $result->fetch_assoc()) {
         $_SESSION["timeout"] = time();
        echo "<tr>";
        $image = $row["Photo"];
        $title = $row["Title"];
        $desc = $row["description"];
        $edition = $row["Edition"];
        $author = $row["Author"];
        $isbn = $row["ISBN"];
        $price = $row["Price"];
        $total = $price*$qty;
        $show = $row["show_img"];
        $thumbimg = $isbn.".jpg";
       
         if($show == "teaser")
             {
             echo "<td><img class=\"memberpic\" src=\"thumbnail/$thumbimg\" alt=\"test\"/></td>";
           
             }
            else {
                echo "<td><img  class=\"memberpic\" src=\"images/$image\" alt=\"test\"/></td>"; 
             }
      
        echo "<td width=\"20%\"><span class = \"special\">$title</span><br/>";
        echo "<span>ISBN:</span>&nbsp;$isbn<br/>";
        echo "<span>Edition:</span>&nbsp;$edition<br/>";
        echo "<span>Price:</span>&nbsp;$price<br/>";
        echo "<span>Author:</span>&nbsp;$author<br/></td>";
        echo "<td><br/> <span>Description:</span><br/>";
        echo "$desc</td>";
        echo "<td><br/> Quantity:&nbsp;<input type=\"text\" class=\"mqty\" id=\"midqty$idno\" value=\"$qty\" size=\"3\"><br/>";
        echo "<br/><button class=\"btn-default mdel\" id=\"middel$idno\">Remove</button>";
        echo "<br/><span  id=\"midspan$idno\" hidden>Invalid Quantity</span>";
        echo "<input type=\"text\" id=\"misbn$idno\" value=\"$isbn\" hidden>";
        echo "<td>$$total</td>";
        echo "</tr>";
        
        
    }
          
           
         
    }
     $idno = $idno +1;
     $final+=$total; 
     $tax = $final * (8/100);
     $tax = round($tax, 2); 
     
     }
     $amount = $final + $tax;
     echo "</table>";
     echo "<p><a class=\"btn-primary btn-lg continue\" href=\"../projects/index.php#displaybooks\" role=\"button\">Continue Shopping &raquo;</a></p>";
     echo "<div id=\"pay\">";
     echo "<span>Total:</span>&nbsp;$$final<br/>";
     echo "<span>Tax:</span>&nbsp;$$tax<br/>";
     echo "<span id=\"finalamt\">Final Amount :&nbsp;$$amount</span><br/>";
     echo "<br/><a href = \"checkout.php\"><button class=\"btn-default\" id=\"checkout\">Checkout</button></a>";
     echo "</div>";
    
    }
     
    ?>
   
    </div>
        
   
    <div class="content-main">
        
    </div>
</div>
     <?php include 'includes/footer.inc.php';
     $_SESSION["timeout"] = time();
     ?>
    </body>
</html>