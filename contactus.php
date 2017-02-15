<?php
//ob_start();
 session_start();


 $userid = "";
 $rolename = "";
 if( !isset($_SESSION['user']) ) {
 }
 else {
     $userid = $_SESSION['user'];
     $rolename = $_SESSION['rolename'];
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
    <div class="container">
    <p><h3 style="text-align: center;"><u> Contact Us </u></h3>
</p>
<div>
    <p style="color: blue;"><h3>Our Address:</h3></p>

 	<p>Plot No.-98, Sector 3, Airoli, Navi Mumbai.</p>
         <p>               District:	Navi Mumbai (Thane)</p>
                       <p> Pin Code:	400 708</p>
<p>State:	Maharashtra</p>
 	 <p>
Phone No:	+91 (022) 27792854, 27791662, 27797130, 27603299 </p>
<p>Fax No:	+91 (022) 27791665</p>
 	 <p>
 	E-mail :<a href="mailto:ritz@gmail.com">principaldmce@yahoo.com</a></p>
         <p>
 	Web site :<a href="#">www.ritzcoaching.com</a>
        </p>
</div>
    </div>
</div>

<div id="mastfooter"><?php include('footer.html'); ?></div>
    </div>
</body>
</html>
<?php //ob_end_flush(); ?>
