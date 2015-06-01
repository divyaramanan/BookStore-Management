<?php if(!isset($_GET['isbn'])){ return; }
?>
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
    <p class="headings">Hi Publisher!!<br/>
    <span>You can now see the different variants of the image for ISBN:<?php echo $_GET['isbn']; ?></span><br/>
        
<?php 
   $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "azteka";
    $conn = new mysqli($servername, $username, $password,$dbname);
    $action = $_GET['action']; 
    
   // Check connection
    if ($conn->connect_error) {
         die("Connection failed: " . $conn->connect_error);
     }
     
      $isbn = $_GET['isbn'];     
       
        if($action == "change")
        {
          $to = $_GET['to'];
          $sql = "UPDATE books SET show_img='$to' WHERE ISBN = '$isbn'"; 
          $result = $conn->query($sql);
          $action="check";
        }
        
        function check($isbn){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "azteka";
    $conn = new mysqli($servername, $username, $password,$dbname);
         $sql = "SELECT * FROM books where ISBN = '$isbn'";
         $result = $conn->query($sql);
         if ($result->num_rows > 0) {
         while($row = $result->fetch_assoc()) 
             {
              $show = $row["show_img"];
              if ($show == "") {
                    return false;
               }
               return true;
             }
         }
         else{
           return false;
         } 
        }
        
        if($action == "check")
        {
         if(check($isbn) == true)
         {
              $filename = "exif_".$isbn.".txt";
             $isbn = $isbn.".jpg";
            
             if (file_exists($filename))       
             {
                 echo "<a href=\"$filename\"><button id=\"exif\">View Exif Data</button></a>";
             }
             else {
                 echo "<span>This Image file does not have Exif data</span>";
             }
             echo "<div id=\"imagediv\">";
       echo "<div><img src='teaser/$isbn' alt='teaser'><p>Teaser</p></div>";       
       echo "<div><img src='blur/$isbn' alt='blur'><p>Blur</p></div>";
       echo "<div><img src='emboss/$isbn' alt='emboss'><p>Emboss</p></div>";
       echo "<div><img src='enhance/$isbn' alt='enhance'><p>Enhance More</p></div>";
       echo "<div><img src='edge/$isbn' alt='Edge'><p>Edge Detection</p></div>";
        echo "<div><img src='watermark/$isbn' alt='wmark'><p>WaterMark</p></div>";       
        echo "</div>";
        echo "<div id=\"thumbnail\"><img src='thumbnail/$isbn' alt='thumbnail'><p class=\"imgp\">Thumbnail</p></div>";
        echo "<div id=\"cover\"><img src='cover/$isbn' alt='thumbnail'><p class=\"imgp\">Book Cover</p></div>";
         }
         else
         {
         echo "<div id=\"noimage\">The ISBN does not exist or image has not been uploaded by publisher</div>";    
         }
        }
      
?>
</div>
 <?php include 'includes/footer.inc.php';    
     ?>
    
</body>
</html>

