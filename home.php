<?php
 ob_start();
 session_start();
 require_once 'dbconnect.php';
 
 // if session is not set this will redirect to login page
 if( !isset($_SESSION['user']) ) {
  header("Location: index.php");
  exit;
 }
 // select loggedin users detail
 //echo $_SESSION['username'];
 $res=mysqli_query($conn,"SELECT * FROM users WHERE userId=".$_SESSION['user']);
 $userRow=mysqli_fetch_array($res);
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
</head>
<body>
    <div id="wrapper">
<div id="mastheader"><?php include('header.html'); ?></div>
 <div id="left-nav">
     <?php 
     $roleid = $userRow['role_id'];
     
     if ($roleid == 1){
         include ('adminmenu.php');
     } else {
        include('studentMenu.php'); 
     }
 ?>
 </div>
 <div id="main-content" style: border="0px;">
     <p> <h3>Greetings <?php echo $_SESSION['username']?> ,</h3></p> 
    <?php include('courses.php'); ?>
    </div>
     
<div id="mastfooter"><?php include('footer.html'); ?></div>
    </div>
    <!--script src="assets/jquery-1.11.3-jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script-->
    
</body>
</html>
<?php ob_end_flush(); ?>