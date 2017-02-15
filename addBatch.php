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
  $cselect = trim($_POST['cselect']);
 // echo $cselect;
  $cselect = strip_tags($cselect);
  $cselect = htmlspecialchars($cselect);
  
  $stdate = trim($_POST['stdate']);
  $stdate = strip_tags($stdate);
  $stdate = htmlspecialchars($stdate);
  
  $enddate = trim($_POST['enddate']);
  $enddate = strip_tags($enddate);
  $enddate = htmlspecialchars($enddate);
  
  $sno = trim($_POST['sno']);
  $sno = strip_tags($sno);
  $sno = htmlspecialchars($sno);
  
  $hrs = trim($_POST['hrs']);
  $hrs = strip_tags($hrs);
  $hrs = htmlspecialchars($hrs);
  
  $schedule = trim($_POST['schedule']);
  $schedule = strip_tags($schedule);
  $schedule = htmlspecialchars($schedule);
  /*
  $mobile = trim($_POST['mobile']);
  $mobile = strip_tags($mobile);
  $mobile = htmlspecialchars($mobile);
  
  $address = trim($_POST['address']);
  $address = strip_tags($address);
  $address = htmlspecialchars($address);
   * */
   
  // basic name validation
  if (empty($cselect) || $cselect == "0") {
   $error = true;
   $cselectError = "Please select Course name.";
  }
    
 
  // password validation
  
  if (empty($stdate)){
   $error = true;
   $stdateError = "Please enter Start Date.";
  } else if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$stdate)) {
   $error = true;
   $stdateError = "Enter Date in correct format (yyyy-mm-dd) ";
  }
  else if (($diff = abs(strtotime($stdate) - strtotime(date('Y-m-d')))) < 86400) {
      $error = true;
   $stdateError = "Enter Date Greater than todays date ";
  }
  
  if (empty($enddate)){
   $error = true;
   $endError = "Please enter End Date.";
  } else if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$enddate)) {
   $error = true;
   $endError = "Enter Date in correct format (yyyy-mm-dd) ";
  }
  else if (($diff = abs(strtotime($enddate) - strtotime($stdate))) < 259200) {
      $error = true;
   $endError = "Enter Date Greater than atleast 3 days to Start Date ";
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
    //  mysqli_autocommit($conn, FALSE);
       $query = "INSERT INTO batch(batchsize,startdate,enddate,schedule,hours_per_day,course_id,teacher_id) 
       VALUES($sno,CAST('". $stdate ."' AS DATE),CAST('". $enddate ."' AS DATE),'$schedule',$hrs,$cselect,3)";
      // echo $query;
   $result = mysqli_query($conn,$query);
   if ($result) {
       
      // mysqli_commit($conn);
   
    $errTyp = "success";
    $errMSG = "Successfully Added Batch";
   
    unset($cselect);
    unset($sno);
    unset($stdate);
    unset($enddate);
    unset($schedule);
    unset($hrs);
    
   } else {
       
       //mysqli_rollback($conn);
   
    $errTyp = "danger";
    $errMSG = "Something went wrong, retry again later..."; 
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

 <div id="batch-form">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
    
     <div class="col-md-12">
        
         <div class="form-group">
             <h3 class="">Add a Batch to a Course.</h3>
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
                <?php 
                $sql= "Select course_id, course_name from course";
                $values = mysqli_query($conn,$sql);
                if(mysqli_num_rows($values)){
                    ?>
             <div class="input-group">
                <!--span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span-->
                 <select class="form-control" name="cselect" placeholder="Select a Course"> 
                    
<?php
    while($rs=mysqli_fetch_array($values)){
        ?>
      <option value="<?php echo $rs['course_id'] ?>"><?php echo $rs['course_name'] ?></option>;
      <?php
  }
?>
                 </select>
                </div>
                <?php 
                }
                ?>
                <span class="text-danger"><?php echo $cselectError; ?></span>
            </div>
        
         
         <div class="form-group">
             <div class="input-group">
                <!--span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span-->
             <input type="text" name="stdate" class="form-control" placeholder="Enter Start Date (yyyy-mm-dd)" maxlength="15" /> 
            </div>
                <span class="text-danger"><?php echo $stdateError; ?></span>
            </div>
         
         <div class="form-group">
             <div class="input-group">
                <!--span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span-->
             <input type="text" name="enddate" class="form-control" placeholder="Enter End Date (yyyy-mm-dd)" maxlength="15" />
                </div>
                <span class="text-danger"><?php echo $endError; ?></span>
            </div>
         
         <div class="form-group">
             <div class="input-group">
                <!--span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span-->
             <input type="number" name="sno" class="form-control" placeholder="Enter Total Batch Size" min="1" />
                </div>
                <span class="text-danger"><?php echo $snoError; ?></span>
            </div>
         
            <div class="form-group">
             <div class="input-group">
                <!--span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span-->
             <textarea name="schedule" class="form-control custom-control" placeholder="Enter Schedule Details" rows="3" style="resize:none"></textarea>
                </div>
                
            </div>
            
            <div class="form-group">
             <div class="input-group">
                <!--span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span-->
             <input type="number" name="hrs" class="form-control" placeholder="Enter Total Hours" min="10" />.
                </div>
                <span class="text-danger"><?php echo $hrsError; ?></span>
            </div>
         
        
         
            
         
         
            <div class="form-group">
             <hr />
            </div>
            
            <div class="form-group">
             <button type="submit"  name="btn-signup">Add Batch</button>
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