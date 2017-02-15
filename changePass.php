<?php
 ob_start();
 session_start();
 if( !isset($_SESSION['user']) ) {
  header("Location: index.php");
  exit;
 }
 else {
     $userid = trim($_SESSION['user']);
     $rolename = $_SESSION['rolename'];
 }
 include_once 'Dbconnect.php';

 $error = false;

 if ( isset($_POST['btn-signup']) ) {
  
  // clean user inputs to prevent sql injections
  $opass = trim($_POST['opass']);
  $opass = strip_tags($opass);
  $opass = htmlspecialchars($opass);
  
  $npass = trim($_POST['npass']);
  $npass = strip_tags($npass);
  $npass = htmlspecialchars($npass);
  
  $cnpass = trim($_POST['cnpass']);
  $cnpass = strip_tags($cnpass);
  $cnpass = htmlspecialchars($cnpass);
   
  // basic name validation
  if (empty($opass)) {
   $error = true;
   $opassError = "Please enter Course name.";
  }
  else {
      $query = "SELECT * FROM users WHERE userid=$userid and userpass='$opass'";
   $result = mysqli_query($conn,$query);
   //echo $result;
   $count = 0;
   if (!empty($result))
        $count = mysqli_num_rows($result);
   if($count==0){
    $error = true;
    $opassError = "Wrong Password entered.";
   }
  }
  
 
  // password validation
  if (empty(trim($npass))){
   $error = true;
   $npassError = "Please enter new password.";
  } else if (strlen($npass) < 6) {
      $error = true;
   $npassError = "Password must be atleast 6 characters..";
  }
  if (empty(trim($cnpass))){
   $error = true;
   $cnpassError = "Please confirm new password.";
  }
  
  if ($opass == $npass){
      $error = true;
   $npassError = " Please Select a new password...";
  }
  
  if ($npass !== $cnpass) {
      $error = true;
   $cnpassError = "New and Confirm password deos not match.. ";
  }
  
  if( !$error ) {
      mysqli_autocommit($conn, FALSE);
   $query = "update users set userpass = '$npass' where userid = $userid";
       
   $res = mysqli_query($conn,$query);
    
   if ($res) {
       
    $errTyp = "success";
    $errMSG = "Successfully changed password ..";
   
    unset($opass);
    unset($npass);
    unset($cnpass);
    
   } else {
       
       mysqli_rollback($conn);
   
    $errTyp = "danger";
    $errMSG = "Something went wrong, retry again later..."; 
   } 
    
  }
  else {
      $errTyp = "danger";
    $errMSG = "Something went wrong, try again later..."; 
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
 <div id="left-nav"><?php 
     
     //echo $rolename;
     if (!empty(trim($rolename))) {
     if ($rolename == "admin"){
         include ('adminmenu.php');
     } else {
        include('studentMenu.php'); 
     }
     }
     else {
         include('indexmenu.php');
     }?>
     </div>
 <div id="main-content" style: border="0px;">
<p> <h3>Greetings <?php echo $_SESSION['username']?> ,</h3></p> 
<div class="container">

 <div id="pass-form">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
    
     <div class="col-md-12">
        
         <div class="form-group">
             <h3 class="">Change Password.</h3>
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
             <input type="password" name="opass" class="form-control" placeholder="Enter old password" maxlength="20" value="" />
                </div>
                <span class="text-danger"><?php echo $opassError; ?></span>
            </div>
            
         <div class="form-group">
             <div class="input-group">
                <!--span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span-->
             <input type="password" name="npass" class="form-control" placeholder="Enter New password" maxlength="20" value="" />
                </div>
                <span class="text-danger"><?php echo $npassError; ?></span>
            </div>
         
         <div class="form-group">
             <div class="input-group">
                <!--span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span-->
             <input type="password" name="cnpass" class="form-control" placeholder="Confirm New password" maxlength="20" value="" />
                </div>
                <span class="text-danger"><?php echo $cnpassError; ?></span>
            </div>
         
            <div class="form-group">
             <hr />
            </div>
            
            <div class="form-group">
             <button type="submit"  name="btn-signup">Change Password</button>
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
<?php 
mysqli_close($conn);
ob_end_flush(); ?>