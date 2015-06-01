<?php include 'includes/sessioncookie.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Author</title>
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
<p class="headings">Welcome Author!!<br/>
        <span>You may now Add,Edit or Delete your Books</span></p>

 
      
    
      
  <div id="errorauthor"></div>

      


<div class="authform">
    <form role="form"  enctype="multipart/form-data" method="post"> 
      
      <div class="row">
      <div class="col-sm-3">
     <div class="form-group">
    <label for="isbn">Enter the ISBN for your Operation<sup>*</sup></label>
    <input type="text" class="form-control focusedInput" id="authisbn"  name="authisbn" >
    </div>
      </div>
      </div>
        
     <div class="row">
         
      <div class="col-sm-5">
      <div class="form-group">
      <label for="isbn">Book Title<sup>*</sup></label>
      <input type="text" class="form-control" id="title"  name="title" disabled>
      </div>
      </div>
         
       <div class="col-sm-3">
      <div class="form-group">
      <label for="isbn">Book Edition<sup>*</sup></label>
      <input type="text" class="form-control" id="edi"  name="edi"  disabled >
      </div>
      </div>
         
       </div>
        
        <div class="row">
         
      <div class="col-sm-8">
      <div class="form-group">
      <label for="isbn">Book Description</label>
      <textarea class="form-control" name="desc" id="desc" rows="2" disabled></textarea>
      </div>
      </div>
     
       </div>
        
        <div class="row">
         
     <div class="col-sm-3">
      <div class="form-group">
      <label for="isbn">Book Image</label>
     <input  type="file" name="img"  id="img" class="file" multiple="true" data-show-upload="false" data-show-caption="true" disabled>
     <input type="hidden" class="form-control" id="imgname"  name="imgname"  >
      </div>
      </div>
     
       </div>
        
  <div id="errorauthor"></div>
  <div class="buttons">
      <button type="submit" class="btn btn-default" id="authAdd" name="authAdd" disabled>Add Book</button>
      <button type="submit" class="btn btn-default" id="authEdit" name="authEdit" disabled>Edit Book</button>
      <button type="submit" class="btn btn-default" id="authDel" name="authDel" disabled>Delete Book</button>
  <button type="reset" class="btn btn-default">Reset</button>
  </div>
 </form>
    <div id="photo"><img id="apic" width="200px"  /></div>
</div>
  <?php include 'includes/footer.inc.php';
     $_SESSION["timeout"] = time();
     ?>
</body>
</html>                       