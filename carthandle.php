<?php 

if(isset($_COOKIE['AZTEKA'])){
        $cookievalue = $_COOKIE['AZTEKA'];
	$id = explode( ',', $cookievalue )[0];
        $cartname = "AZCART".$id;
        $cartval = $_COOKIE[$cartname];
        $action = $_GET['action'];
        $isbn = $_GET['isbn'];
        $newcartval ="";
        if($action == "add")
        {      
           if($cartval == "empty")
            {
               $newcartval = $isbn.",1";
         
            }
           else
            {
              $newcartval = $cartval."||".$isbn.",1";
            }
            setcookie($cartname, $newcartval, time() + (86400 * 30), "/");
            echo "done";
        } 
        if($action == "update")
        {
           $qty =  $_GET['qty'];
           $items = explode("||",$cartval);
            foreach($items as $i)
            {
              $cookieisbn = explode(",",$i)[0];
              $cookieqty = explode(",",$i)[1];
              if($isbn == $cookieisbn)
              {
                  $oldentry = $cookieisbn.",".$cookieqty;
                  $newentry = $isbn.",".$qty;
                   $cartval = str_replace($oldentry,$newentry,$cartval);
                  
              }
            }
            setcookie($cartname, $cartval, time() + (86400 * 30), "/");
            echo "done";
       }
       if($action == "delete")
       {  
          
           $cnt = cartcount($cartval);
           if($cnt == 1)
           {
               $cartval = "empty";
           }
           else
           {
            $items = explode("||",$cartval);
            foreach($items as $i)
            {
              $cookieisbn = explode(",",$i)[0];
              $cookieqty = explode(",",$i)[1];
              if($isbn == $cookieisbn)
              {
                  $oldentry = $cookieisbn.",".$cookieqty;
                  
              }
            }
            $key = array_search($oldentry, $items); 
            array_splice($items, $key, 1);
           
            foreach($items as $i)
            {
             $newcartval .= $i."||";   
            }
            
            
            $cartval = substr($newcartval,0,strlen($newcartval)-2);
            
           }
           setcookie($cartname, $cartval, time() + (86400 * 30), "/");
           echo "done";  
       }
      
       
}

 function cartcount($cartval){
            $items = explode("||",$cartval);
            $count = 0;
            if($cartval != "empty")
            {
                
            foreach($items as $i)
            {
              $cookieqty = explode(",",$i)[1];
              $count = $count + $cookieqty;
            }
            
            }
            return $count;
           
       }

?>