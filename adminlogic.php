<?php 
if(isset($_POST['indexsubmit']))
    {
     if(empty($_POST["login"])) {
     $indexErr = "*Email is required";    
    
    } else {
           $email = $_POST["login"];
           // check if e-mail address is well-formed
           if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
           {
           $indexErr = "*Invalid email format";   
           }
          else
           {
            if(empty($_POST["indexpassword"])) {
              $indexErr = "*Password is required";    
             }
            else
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
  
              $sql = "SELECT password,userlevel FROM users WHERE Email = '$email'";

        
              $result = $conn->query($sql);


             if ($result->num_rows > 0) {
                       // output data of each row
    
                     while($row = $result->fetch_assoc()) {
                           if(sha1($indexpassword)==trim($row["password"]))
                            {
                            $email="";
                            $cmd = $row["userlevel"];
                           
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
     }
   }
   return $indexErr;
}

?>