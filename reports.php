

<!DOCTYPE html>
<html>


          
    <?php
ob_start();
 session_start();

 
 // if session is not set this will redirect to login page
 $userid = "";
 $rolename = "";
 if( !isset($_SESSION['user']) ) {
  header("Location: index.php");
  exit;
     
 }
 else {
     $userid = trim($_SESSION['user']);
     $rolename = $_SESSION['rolename'];
 }
$error = false;

?>
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
     }
 ?>
 </div>
<div id="main-content" style: border="0px;">
    <h3>Greetings <?php echo trim($_SESSION['username'])?></h3>
</p>
<p><u>  Reports</u> </p>
<div id="course_report">
    <p><ui>
        <li> <a href="coursewiseRevenue.php">Course wise Generated Revenue</a></li>
        <li> <a href="batchwiseStudentReport.php">Batch wise Students</a></li>
    </ui>
        
    </p>
</div>
</div>
<div id="mastfooter"><?php include('footer.html'); ?></div>
    </div>
</body>
</html>