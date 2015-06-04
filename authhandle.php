<!-- Author operations like adding books to database, editing/deleting the books the author has created are done in this PHP -->
<?php include 'includes/sessioncookie.php'; ?>
<?php 
   $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "azteka";
    $conn = new mysqli($servername, $username, $password,$dbname);

   // Check connection
    if ($conn->connect_error) {
         die("Connection failed: " . $conn->connect_error);
     }
      $_SESSION["timeout"] = time();
      
       if(isset($_COOKIE['AZTEKA'])){
        $cookievalue = $_COOKIE['AZTEKA'];
	$id = explode( ',', $cookievalue )[0];
        $isbn = $_GET['isbn'];
        $action = $_GET['action'];
        $_SESSION["timeout"] = time();
        
        if($action == "add")
        {      
          $title = $_GET['title'];
          $edi = $_GET['edition'];
          $desc = $_GET['desc'];
          $img = $_GET['img'];
          $price = 0.0;
          $best = "No";
          $status = "Unpublish";
          
         $namesql = "SELECT Name FROM enroll,users where users.id=$id AND users.Email = enroll.email";
         $result = $conn->query($namesql);
         $name = "";
         if ($result->num_rows > 0) {
         while($row = $result->fetch_assoc()) 
             {
             $name = $row["Name"];
             }
         }
          $stmt = $conn->prepare("INSERT INTO books(ISBN,Title,Edition,Price,Author,Author_id,description,Photo,bestseller,status)
VALUES(?,?,?,?,?,?,?,?,?,?)");
$stmt->bind_param("ssidsissss",$isbn,$title,$edi,$price,$name,$id,$desc,$img,$best,$status);

$resultenroll = $stmt->execute();
          echo "Inserted";
        } 
        if($action == "update")
        {
          $title = $_GET['title'];
          $edi = $_GET['edition'];
          $desc = $_GET['desc'];
          $img = $_GET['img'];
          $sql = "UPDATE books SET Title = '$title',Edition = '$edi',Description = '$desc',Photo = '$img' WHERE ISBN = '$isbn'"; 
          $result = $conn->query($sql);
          echo "Edited";
        }
        if($action == "delete")
        {  
          $sql = "DELETE FROM books where ISBN = '$isbn'";
          $result = $conn->query($sql);
          echo "deleted";
          
        }
        if($action == "check")
        {
         $sql = "SELECT * FROM books where ISBN = '$isbn'";
         $result = $conn->query($sql);
         if ($result->num_rows > 0) {
         while($row = $result->fetch_assoc()) 
             {
             
                     if($id == $row["Author_id"])
                        {
                            $image = $row["Photo"];
                            $title = $row["Title"];
                            $desc = $row["description"];
                            $edition = $row["Edition"];
                            
                            echo $title."||".$edition."||".$desc."||".$image;
                        }
                     else
                         {
                         echo "Not Eligible";
                         }
                      
        
             }
         }
         else{
           echo "Add";  
         }
        }
      if($action == "pubcheck")
        {
         $sql = "SELECT * FROM books where ISBN = '$isbn'";
         $result = $conn->query($sql);
         if ($result->num_rows > 0) {
         while($row = $result->fetch_assoc()) 
             {
                                      
                            $title = $row["Title"];
                            $author = $row["Author"];
                            echo $title."||".$author;
                         
             }
         }
         else{
           echo "invalid";  
         }
        }
       
}

 

?>
