<!DOCTYPE html>

  


<?php
 ob_start();
 session_start();
 require_once 'Dbconnect.php';
 
 // it will never let you open index(login) page if session is set
 if ( isset($_SESSION['user'])!="" ) {
  header("Location: home.php");
  exit;
 }
 
 $error = false;
 
 if( isset($_POST['btn-login']) ) { 
  
  // prevent sql injections/ clear user invalid inputs
  $uname = trim($_POST['uname']);
  $uname = strip_tags($uname);
  $uname = htmlspecialchars($uname);
  
  $pass = trim($_POST['pass']);
  $pass = strip_tags($pass);
  $pass = htmlspecialchars($pass);
  // prevent sql injections / clear user invalid inputs
  
  if(empty($uname)){
   $error = true;
   $unameError = "Please enter your Username.";
  } 
  
  if(empty($pass)){
   $error = true;
   $passError = "Please enter your password.";
  }
  
  // if there's no error, continue to login
  if (!$error) {
   
   //$password = hash('sha256', $pass); // password hashing using SHA256
      $password = $pass;
  
   $res=mysqli_query($conn,"SELECT userId, userName, userPass, role_name FROM users u, roles r WHERE username='$uname' and u.role_id = r.role_id");
   $row=mysqli_fetch_array($res);
   $count = mysqli_num_rows($res); // if uname/pass correct it returns must be 1 row
   
   if( $count == 1 && $row['userPass']==$password ) {
    $_SESSION['user'] = $row['userId'];
    $_SESSION['username'] = $row['userName'];
    $_SESSION['rolename'] = $row['role_name'];
    header("Location: home.php");
   } else {
    $errMSG = "Incorrect Credentials, Try again...";
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
<body>
    <div id="wrapper">
<div id="mastheader"><?php include('header.html'); ?></div>
 <div id="left-nav"><?php include('indexmenu.php'); ?></div>
 <div id="main-content" style: border="0px;">
<div class="container">

 <div id="login-form">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
    
     <div class="col-md-12">
        
         <div class="form-group">
             <h2 class="">Sign In.</h2>
            </div>
        
         <div class="form-group">
             <hr />
            </div>
            
            <?php
   if ( isset($errMSG) ) {
    
    ?>
    <div class="form-group">
             <div class="alert alert-danger">
    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
             </div>
                <?php
   }
   ?>
            
            <div class="form-group">
             <div class="input-group">
                <!--span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span-->
             <input type="text" name="uname" class="form-control" placeholder="Username" value="<?php echo $uname; ?>" maxlength="40" />
                </div>
                <span class="text-danger"><?php echo $unameError; ?></span>
            </div>
            
            <div class="form-group">
             <div class="input-group">
                <!--span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span-->
             <input type="password" name="pass" class="form-control" placeholder="Password" maxlength="15" />
                </div>
                <span class="text-danger"><?php echo $passError; ?></span>
            </div>
            
            <div class="form-group">
             <hr />
            </div>
            
            <div class="form-group">
             <button type="submit" name="btn-login">Sign In</button>
            </div>
            
            
            
            <div class="form-group">
             <a href="register.php">Sign Up Here...</a>
            </div>
        
        </div>
   
    </form>
    </div> 

</div> </div>
<div id="mastfooter"><?php include('footer.html'); ?></div>
</div>
</body>
</html>
<?php ob_end_flush(); ?>
