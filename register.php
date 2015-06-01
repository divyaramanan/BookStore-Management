<!DOCTYPE html>
<html lang="en">
<head>
  <title>Register</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="./bootstrap/css/overides.css"/>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script type=text/javascript src="javaSript.js"></script>
  <script src="./bootstrap/js/bootstrap.min.js"></script>
</head>
<body>



<div class="container-fluid">
     <?php include 'includes/header_select.inc.php';
     ?>
    	<form role="form" id="regform" action="enroll.php" method="post">
           
	<div class="control-group">

<div class="controls form-group-sm">
  <div id="personal">
            <p id="personalinfo">Personal Information</p>
<div class="row">
<div class="col-sm-5">
<div class="form-group">
    <label for="fname">First Name</label>
    <input type="text" class="form-control focusedInput" id="fname" name="fname" placeholder="John">
  </div>
</div>
<div class="col-sm-5">
<div class="form-group">
    <label for="lname">Last Name</label>
    <input type="text" class="form-control" id="lname" name="lname" placeholder="Smith">
  </div>
</div>
</div>
    <div class="row">
<div class="col-sm-10">
<div class="form-group">
    <label for="add">Address</label>
    <input type="text" class="form-control" id="add" name="add" placeholder="123 Main Street Apt:#109">
  </div>
</div>
</div>
    <div class="row">
<div class="col-sm-5">
<div class="form-group">
    <label for="City">City</label>
    <input type="text" class="form-control" id="city" name="city" placeholder="San Diego">
  </div>
</div>
<div class="col-sm-2">
<div class="form-group">
    <label for="state">State</label>
    <input type="text" class="form-control" id="state" name="state" placeholder="CA">
  </div>
</div>
<div class="col-sm-3">
<div class="form-group">
    <label for="zip">ZipCode</label>
    <input type="text" class="form-control" id="zip" name="zip" placeholder="99108">
  </div>
</div>
</div>
     <div class="row">
<div class="col-sm-4">
<div class="form-group">
    <label for="phone">Mobile</label>
    <input type="phone" class="form-control" id="phone" name="phone" placeholder="312-213-3312">
  </div>
</div>
         <div class="col-sm-4">
<div class="form-group">
    <label for="lphone">LandLine</label>
    <input type="phone" class="form-control" id="lphone" name="lphone" placeholder="312-213-3312">
  </div>
</div>
</div>
</div>

 <div id="loginside">
     <p>Login Information </p>
<div class="col-sm-7">
<div class="form-group">
    <label for="email">Email</label>
    <input type="email" class="form-control" id="email" name="email" placeholder="someone@example.com">
  </div>
</div>


<div class="col-sm-5">
<div class="form-group">
    <label for="rpass">Password</label>
    <input type="password" class="form-control" id="rpass" name="rpass">
  </div>
</div>
     
<div class="col-sm-5">
<div class="form-group">
    <label for="repass">Retype Password</label>
    <input type="password" class="form-control" id="repass" name="repass">
  </div>
</div>
     
 <div class="col-sm-10">
<div class="form-group">
    <label for="quest">Security Question</label>
    <input type="text" class="form-control" id="quest" name="quest" placeholder="What is my Dream destiny?">
  </div>
</div>
     
 <div class="col-sm-5">
<div class="form-group">
    <label for="ans">Answer</label>
    <input type="password" class="form-control" name="ans" id="ans">
  </div>
</div>
  
</div>
       
   <div class="col-sm-10">
      <div class="form-group register">
          
 <button type="submit" class="btn btn-default" id="regsubmit">Submit</button>
  <button type="reset" class="btn btn-default">Reset</button>   
      </div>
  </div>    
           
            </div>
            </div>
     
   
      
        </form>
    <div id="regstatus">Note: All the fields in the form are required.</div>		    		
</div>
     <?php include 'includes/footer.inc.php';
     ?>
    </body>
</html>