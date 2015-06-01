    <?php
        $img_dir = 'images/';
        $comp_dir='C:\xampp\htdocs\xampp\projects';
        $pname=$_FILES['img']['name'];
	echo $pname;
        
        
		
               // Check if file already exists
       if (file_exists($img_dir.$pname)) {
          //echo "Sorry, file already exists.";
          }
            
       // Check if error exists
       elseif ($_FILES['img']['error']>0) {
       $err=$_FILES['img']['error'];
       echo "ERROR: $err";
          }
        else{
          move_uploaded_file($_FILES['img']['tmp_name'],"$img_dir".$pname);
           }
          ?>
          <?php
          $d=dir($comp_dir);
          while($pname=$d->read())
          {
          $data[$pname]=stat($pname);
          }
          foreach($data as $pname => $pvalue){
          if($pname== "." ||$pname== "..")
          {
          ;
          }
          else
          {
          if($pname == $_FILES['img']['name'])
          {
          echo "<img src=\"$img_dir/$pname\""."  />";
          break;
          }
          }
          
          }

          ?>