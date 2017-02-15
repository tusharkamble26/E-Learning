<?php
 ob_start();
 session_start();
 if( isset($_SESSION['user'])!="" ){
  //header("Location: home.php");
 }
 include_once 'Dbconnect.php';

 $error = false;

 if ( isset($_POST['btn-signup']) ) {
  
  // clean user inputs to prevent sql injections
  $uname = trim($_POST['uname']);
  $uname = strip_tags($uname);
  $uname = htmlspecialchars($uname);
  
  $email = trim($_POST['email']);
  $email = strip_tags($email);
  $email = htmlspecialchars($email);
  
  $pass = trim($_POST['pass']);
  $pass = strip_tags($pass);
  $pass = htmlspecialchars($pass);
  
  $fname = trim($_POST['fname']);
  $fname = strip_tags($fname);
  $fname = htmlspecialchars($fname);
  
  $mname = trim($_POST['mname']);
  $mname = strip_tags($mname);
  $mname = htmlspecialchars($mname);
  
  $lname = trim($_POST['lname']);
  $lname = strip_tags($lname);
  $lname = htmlspecialchars($lname);
  
  $mobile = trim($_POST['mobile']);
  $mobile = strip_tags($mobile);
  $mobile = htmlspecialchars($mobile);
  
  $address = trim($_POST['address']);
  $address = strip_tags($address);
  $address = htmlspecialchars($address);
  // basic name validation
  if (empty($uname)) {
   $error = true;
   $unameError = "Please enter your login name.";
  } else if (strlen($uname) < 6) {
   $error = true;
   $unameError = "login Name must have atleat 6 characters.";
  } 
  /*else if (!preg_match("/^[a-zA-Z ]/",$uname)) {
   $error = true;
   $unameError = "login Name must contain alphabets and space.";
  }*/
  else {
      $query = "SELECT username FROM users WHERE username='$uname'";
   $result = mysqli_query($conn,$query);
   $count = mysqli_num_rows($result);
   if($count!=0){
    $error = true;
    $unameError = "Provided Login Name is already in use.";
   }
  }
  
  //basic email validation
  if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
   $error = true;
   $emailError = "Please enter valid email address.";
  } else {
   // check email exist or not
   $query = "SELECT userEmail FROM users WHERE userEmail='$email'";
   $result = mysqli_query($conn,$query);
   $count = mysqli_num_rows($result);
   if($count!=0){
    $error = true;
    $emailError = "Provided Email is already in use.";
   }
  }
  // password validation
  if (empty($pass)){
   $error = true;
   $passError = "Please enter password.";
  } else if(strlen($pass) < 6) {
   $error = true;
   $passError = "Password must have atleast 6 characters.";
  }
  
  if (empty($fname)) {
   $error = true;
   $fnameError = "Please enter your first name.";
  } else if (!preg_match("/^[a-zA-Z ]/",$fname)) {
   $error = true;
   $fnameError = "First Name must contain alphabets and space.";
  }
  
  if (empty($lname)) {
   $error = true;
   $lnameError = "Please enter your Last name.";
  } else if (!preg_match("/^[a-zA-Z ]/",$lname)) {
   $error = true;
   $lnameError = "Last Name must contain alphabets and space.";
  }
  if (empty($mobile)) {
   $error = true;
   $phoneError = "Please enter your Phone no.";
  }
  // password encrypt using SHA256();
  //$password = hash('sha256', $pass);
  $password = $pass;
  // if there's no error, continue to signup
  if( !$error ) {
   
   $query = "INSERT INTO users(userName,userEmail,userPass,fname,mname,lname,mobile,address,role_id) 
       VALUES('$uname','$email','$password','$fname','$mname','$lname','$mobile','$address',4)";
   $res = mysqli_query($conn,$query);
    
   if ($res) {
    $errTyp = "success";
    $errMSG = "Successfully registered, you may login now";
    unset($uname);
    unset($email);
    unset($pass);
    unset($fname);
    unset($mname);
    unset($lname);
    unset($mobile);
    unset($address);
   } else {
    $errTyp = "danger";
    $errMSG = "Something went wrong, try again later..."; 
   } 
    
  }
  
  
 }
?>
<!DOCTYPE html>
<html>
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Ritz Coaching Classes</title>
        <link href="css/basic.css" rel="stylesheet" type="text/css" media="all">
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
        <link href="css/style.css" rel="stylesheet" type="text/css" media="all">

        <script src="js/jquery.min.js"></script>

    


<!--link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="style.css" type="text/css" /-->
</head>
<body style="overflow: scroll;">
    <div id="wrapper">
<div id="mastheader"><?php include('header.html'); ?></div>
 <div id="left-nav"><?php include('indexmenu.php'); ?></div>
 <div id="main-content" style: border="0px;">

<div class="container">

 <div id="login-form">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
    
     <div class="col-md-12">
        
         <div class="form-group">
             <h3 class="">Register.</h3>
            </div>
        
            
            <?php
   if ( isset($errMSG) ) {
    
    ?>
    <div class="form-group">
             <div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
             </div>
                <?php
   }
   ?>
            
            <div class="form-group">
             <div class="input-group">
                <!--span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span-->
             <input type="text" name="uname" class="form-control" placeholder="Enter a Login Name" maxlength="50" value="<?php echo $name ?>" />
                </div>
                <span class="text-danger"><?php echo $unameError; ?></span>
            </div>
            
            <div class="form-group">
             <div class="input-group">
                <!--span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span-->
             <input type="email" name="email" class="form-control" placeholder="Enter Your Email" maxlength="40" value="<?php echo $email ?>" />
                </div>
                <span class="text-danger"><?php echo $emailError; ?></span>
            </div>
            
            <div class="form-group">
             <div class="input-group">
                <!--span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span-->
             <input type="password" name="pass" class="form-control" placeholder="Enter Password" maxlength="15" />
                </div>
                <span class="text-danger"><?php echo $passError; ?></span>
            </div>
         
         <div class="form-group">
             <div class="input-group">
                <!--span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span-->
             <input type="text" name="fname" class="form-control" placeholder="Enter First Name" maxlength="35" />
                </div>
                <span class="text-danger"><?php echo $fnameError; ?></span>
            </div>
         <div class="form-group">
             <div class="input-group">
                <!--span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span-->
             <input type="text" name="mname" class="form-control" placeholder="Enter Middle Name" maxlength="35" />
                </div>
                
            </div>
         <div class="form-group">
             <div class="input-group">
                <!--span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span-->
             <input type="text" name="lname" class="form-control" placeholder="Enter Last Name" maxlength="35" />
                </div>
                <span class="text-danger"><?php echo $lnameError; ?></span>
            </div>
         <div class="form-group">
             <div class="input-group">
                <!--span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span-->
             <input type="text" name="mobile" class="form-control" placeholder="Enter Phone" maxlength="15" />
                </div>
                <span class="text-danger"><?php echo $phoneError; ?></span>
            </div>
            
         <div class="form-group">
             <div class="input-group">
                <!--span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span-->
             <textarea name="address" class="form-control custom-control" placeholder="Enter Address" rows="3" style="resize:none"></textarea>
                </div>
                
            </div>
         
            <div class="form-group">
             <hr />
            </div>
            
            <div class="form-group">
             <button type="submit"  name="btn-signup">Sign Up</button>
            </div>
            
            
           
        
        </div>
   
    </form>
    </div> 

</div>
 </div>
 <div id="mastfooter"><?php include('footer.html'); ?></div>
    </div>
</body>
</html>
<?php ob_end_flush(); ?>