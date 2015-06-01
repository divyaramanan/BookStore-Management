<?php
if(!isset($_COOKIE['AZTEKA']))
{
if(!isset($_COOKIE['best']))
{
  setcookie("best",1, time() + (86400 * 30), "/");   
}
else 
{
 $visit = $_COOKIE['best'];
 $visit = $visit + 1;
  setcookie("best",$visit, time() + (86400 * 30), "/");
}
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <title>Best Sellers</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="./bootstrap/css/overides.css"/>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script type=text/javascript src="javaSript.js"></script>
   <script type=text/javascript src="ajax_get_lib.js"></script>
  <script src="./bootstrap/js/bootstrap.min.js"></script>
 
  <link class="include" rel="stylesheet" type="text/css" href="jquery-ui/jquery.jqplot.min.css" />
    
    <link type="text/css" rel="stylesheet" href="syntaxhighlighter/styles/shCoreDefault.min.css" />
    <link type="text/css" rel="stylesheet" href="syntaxhighlighter/styles/shThemejqPlot.min.css" />
  
</head>
<body>

        

<div class="container-fluid">
 <?php include 'includes/header_select.inc.php';
     ?>
    <p id="best">Our Best Sellers of 2015</p>
     <div class="row fetchbooks">
  
   <?php 
   $servername = "localhost";
$username = "root";
$password = "";
$dbname = "azteka";
$cartval = "";
$cookievalue = "";

if(isset($_COOKIE['AZTEKA'])){
        $cookievalue = $_COOKIE['AZTEKA'];
	$id = explode( ',', $cookievalue )[0];
        $cartname = "AZCART".$id;
        if(isset($_COOKIE[$cartname]))
        {
            $cartval = $_COOKIE[$cartname];
            
        }
        //$cartarray = explode( '||', $cartval );
                
    }
    

// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT * FROM books WHERE bestseller='Yes' AND status = 'Publish'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    $idno = 1;
    while($row = $result->fetch_assoc()) {
      
        $image = $row["Photo"];
        $title = $row["Title"];
        $author = $row["Author"];
        $isbn = $row["ISBN"];
        $price = $row["Price"];
        $isbnpattern = "/$isbn/";
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
$conn->close();
   
   ?>
    
</div>
</div>
    <p class="headings">A Plot of Books and its sold numbers</p>
  <div id="chart1"></div>

<!-- End example scripts -->

<!-- Don't touch this! -->


<script class="include" type="text/javascript" src="jquery-ui/jquery.jqplot.min.js"></script>
    <script type="text/javascript" src="syntaxhighlighter/scripts/shCore.min.js"></script>
    <script type="text/javascript" src="syntaxhighlighter/scripts/shBrushJScript.min.js"></script>
    <script type="text/javascript" src="syntaxhighlighter/scripts/shBrushXml.min.js"></script>
	


  <script class="include" type="text/javascript" src="plugins/jqplot.barRenderer.min.js"></script>
  <script class="include" type="text/javascript" src="plugins/jqplot.pieRenderer.min.js"></script>
  <script class="include" type="text/javascript" src="plugins/jqplot.categoryAxisRenderer.min.js"></script>
  <script class="include" type="text/javascript" src="plugins/jqplot.pointLabels.min.js"></script>


    
    <?php include 'includes/footer_best.inc.php';
   
     ?>
</body>
</html>