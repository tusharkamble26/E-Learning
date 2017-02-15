<?php
 ob_start();
 session_start();
 if( !isset($_SESSION['user']) ) {
  header("Location: index.php");
  exit;
 }
 include_once 'Dbconnect.php';

 $error = false;

 if ( isset($_POST['btn-signup']) ) {
  
  // clean user inputs to prevent sql injections
  $cname = trim($_POST['cname']);
  $cname = strip_tags($cname);
  $cname = htmlspecialchars($cname);
  
  $cdet = trim($_POST['cdet']);
  $cdet = strip_tags($cdet);
  $cdet = htmlspecialchars($cdet);
  
  $fees = trim($_POST['fees']);
  $fees = strip_tags($fees);
  $fees = htmlspecialchars($fees);
  /*
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
   * */
   
  // basic name validation
  if (empty($cname)) {
   $error = true;
   $cnameError = "Please enter Course name.";
  }
  else {
      $query = "SELECT course_name FROM course WHERE course_name='$cname'";
   $result = mysqli_query($conn,$query);
   $count = mysqli_num_rows($result);
   if($count!=0){
    $error = true;
    $cnameError = "Course Name is already in use.";
   }
  }
  
 
  // password validation
  if (empty($fees)){
   $error = true;
   $feesError = "Please enter password.";
  } else if(!is_numeric($fees) || $fees == 0) {
   $error = true;
   $feesError = "Enter Non Zero Numeric values for fees ";
  }
  /*
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
   * 
   */
  // if there's no error, continue to signup
  if( !$error ) {
      mysqli_autocommit($conn, FALSE);
   $query = "INSERT INTO course(course_name,course_details,fees) 
       VALUES('$cname','$cdet','$fees')";
   $res = mysqli_query($conn,$query);
    
   if ($res) {
       $cid = mysqli_insert_id($conn);
       
       $stdate = "2016-11-12";
       $enddate = "2016-12-12";
       $query = "INSERT INTO batch(batchsize,startdate,enddate,course_id,teacher_id) 
       VALUES('30',CAST('". $stdate ."' AS DATE),CAST('". $enddate ."' AS DATE), $cid,3)";
   $result = mysqli_query($conn,$query);
   if ($result) {
       
       mysqli_commit($conn);
   
    $errTyp = "success";
    $errMSG = "Successfully Added Course";
   
    unset($cname);
    unset($cdet);
    unset($fees);
    
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
 <div id="left-nav"><?php include('adminmenu.php'); ?></div>
 <div id="main-content" style: border="0px;">
<p> <h3>Greetings <?php echo $_SESSION['username']?> ,</h3></p> 
<div class="container">

 <div id="login-form">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
    
     <div class="col-md-12">
        
         <div class="form-group">
             <h3 class="">Register Course.</h3>
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
             <input type="text" name="cname" class="form-control" placeholder="Enter a Course Name" maxlength="40" value="<?php echo $name ?>" />
                </div>
                <span class="text-danger"><?php echo $cnameError; ?></span>
            </div>
            
            <div class="form-group">
             <div class="input-group">
                <!--span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span-->
             <textarea name="cdet" class="form-control custom-control" placeholder="Enter Details" rows="3" style="resize:none"></textarea>
                </div>
                
            </div>
            
            <div class="form-group">
             <div class="input-group">
                <!--span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span-->
             <input type="text" name="fees" class="form-control" placeholder="Enter Total Fees" maxlength="15" />
                </div>
                <span class="text-danger"><?php echo $feesError; ?></span>
            </div>
         
        
         
            
         
         
            <div class="form-group">
             <hr />
            </div>
            
            <div class="form-group">
             <button type="submit"  name="btn-signup">Add Course</button>
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