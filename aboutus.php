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
    <p><h3> Welcome to Ritz Coaching </h3>
</p>
<div>
    <p><i>
        Ritz Coaching is an educational institute which specializes in teaching Technical courses to College Students.</p>
        <p>The organization has created a niche for itself in the technical courses
        and is today the fastest growing </p><p>Coaching Institute.
        </i></p>
        <p><i>
                Ritz Coaching brings to you the most Specialized & Professional way of Teaching. The lectures are participative</p>
        <p>and illustrative perfectly blended and suited for the course & students future job as well.</p>
<p>Our aim is to become the most preferred Coaching Institute in India for Technical Courses.
    This would be done by</p><p> providing the students with the best teaching, right guidance & motivation to help them excel in their performance.
</p><p>In this way we would be able to contribute to the growth of our economy by creating a pool of </p><p>
    knowledgeable professionals.
            </i>
        </p>
</div>
    </div>
</div>

<div id="mastfooter"><?php include('footer.html'); ?></div>
    </div>
</body>
</html>
<?php //ob_end_flush(); ?>