<?php include 'includes/sessioncookie.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Publisher</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="./bootstrap/css/overides.css"/>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
   <script type=text/javascript src="javaSript.js"></script>
    <script type=text/javascript src="ajax_get_lib.js"></script>
  <script src="./bootstrap/js/bootstrap.min.js"></script>
</head>
<body>


<div class="container-fluid">
 <?php include 'includes/header_select.inc.php';
     ?>
    <p id="publish">Welcome Publisher!!<br/>
    <span>Add/Remove the Best Sellers or Edit the price of the book.
        Hover on the images for options</span><br/>
        <span id="publisherr" >Changes will be saved automatically unless cost value is invalid</span><br/></p>
        
     <div class="row fetchbooks">
  
   <?php 
   $servername = "localhost";
$username = "root";
$password = "";
$dbname = "azteka";
$_SESSION["timeout"] = time();

// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT * FROM books WHERE bestseller='Yes'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    $idno = 1;
    $_SESSION["timeout"] = time();
    while($row = $result->fetch_assoc()) {
        $_SESSION["timeout"] = time();
        $image = $row["Photo"];
        $title = $row["Title"];
        $isbn = $row["ISBN"];
        $price = $row["Price"];
        $status = $row["status"];
        if($status == "Publish")
        { $ischeck = "checked";}
        else {
         $ischeck = "";   
        }
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
     echo "<figcaption>$title<br/><br/>ISBN:&nbsp;$isbn<br/><br/>Price:&nbsp;<input type=\"text\" size=\"6\" class=\"cost\" id=\"rcostid$idno\" value=\"$price\"/>$<br/><br/>"; 
     echo "<button class=\"btn btn-default removebest\" id=\"rbid$idno\" >Remove from Best Seller</button><br/><br/>";
     echo "<input type=\"text\" id=\"rid$idno\" value=\"$isbn\" hidden>";
     echo "<label><input type=\"checkbox\" class=\"pchk\" id=\"rpub$idno\" $ischeck>  Publish</label>";
     echo "</figcaption></figure></div>"; 
     $idno = $idno+1;
    }
} 

$sqlNobest = "SELECT * FROM books WHERE bestseller='No'";
$resultNobest = $conn->query($sqlNobest);

if ($resultNobest->num_rows > 0) {
    // output data of each row
     $idno = 1;
     $_SESSION["timeout"] = time();
    while($row = $resultNobest->fetch_assoc()) {
        $_SESSION["timeout"] = time();
        $image = $row["Photo"];
        $title = $row["Title"];
        $isbn = $row["ISBN"];
        $price = $row["Price"];
        $status = $row["status"];
        if($status == "Publish")
        { $ischeck = "checked";}
        else {
         $ischeck = "";   
        }
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
     echo "<figcaption>$title<br/><br/>ISBN:&nbsp;$isbn<br/><br/>Price:&nbsp;<input type=\"text\" size=\"6\" class=\"cost\" id=\"acostid$idno\" value=\"$price\"/>$<br/><br/>"; 
     echo "<button class=\"btn btn-default addbest\" id=\"abid$idno\" >Add to Best Seller</button><br/><br/>";
     echo "<input type=\"text\" id=\"aid$idno\" value=\"$isbn\" hidden>";
     echo "<label><input type=\"checkbox\" class=\"pchk\" id=\"apub$idno\" $ischeck>  Publish</label>";
     echo "</figcaption></figure></div>"; 
      $idno = $idno+1;
    }
} 
$conn->close();
   
   ?>
    
</div>
    <div>
        <p class="headings">Image Upload<br/>
    <span>View Images show different variations of your image</span><br/>
        <span id="uploaderr" ></span><br/></p>
       
          
        <form role="form"   id="form_py"> 
      
      <div class="row">
      <div class="col-sm-3">
     <div class="form-group">
    <label for="isbn">Enter the ISBN for your Operation<sup>*</sup></label>
    <input type="text" class="form-control focusedInput" id="pubisbn"  name="pubisbn" >
    </div>
      </div>
      </div>
        
     <div class="row">
         
      <div class="col-sm-5">
      <div class="form-group">
      <label for="isbn">Book Title</label>
      <input type="text" class="form-control" id="pubtitle"  name="pubtitle" disabled>
      </div>
      </div>
         
       </div>
         
       <div class="row">         
        <div class="col-sm-3">
      <div class="form-group">
     
     <label class="checkbox-inline"><input type="checkbox" id="ratio" name="ratio">Preserve Aspect Ratio</label>
      </div>
      </div>
       </div>
       
       
        
        <div class="row">
         
     <div class="col-sm-3">
      <div class="form-group">
      <label for="isbn">Book Image</label>
     <input  type="file" name="img"  id="img" class="file" multiple="true" data-show-upload="false" data-show-caption="true">
      </div>
      </div>
     
       </div>
        
         <div class="buttons">
      <button type="submit" class="btn btn-default" id="upSubmit" name="upSubmit" >Submit</button>     
      <button type="reset" class="btn btn-default">Reset</button>
      <button type="button" class="btn btn-default" id="upView" name="upView">View Images</button>
       </div>
    </form>
        </div>
    </div>

      
    <?php include 'includes/footer.inc.php';
    $_SESSION["timeout"] = time();
     ?>
</body>
</html>