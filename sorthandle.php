

   
    
 <?php 
 
  $sortval = $_GET['sortval'];
  setcookie("SORT",$sortval, time() + (86400 * 30), "/");  
  echo $sortval;
   ?>
     

 
