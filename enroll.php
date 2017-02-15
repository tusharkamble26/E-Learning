<?php
 ob_start();
 session_start();
 require_once 'dbconnect.php';
 
 // if session is not set this will redirect to login page
 $userid = "";
 if( !isset($_SESSION['user']) ) {
  header("Location: index.php");
  exit;
 }
 else {
     $userid = trim($_SESSION['user']);
 }
 
 $error = false;
 $cid = trim($_GET['cid']);
  $cid = strip_tags($cid);
  $cid = htmlspecialchars($cid);
  
  $bid = trim($_GET['bid']);
  $bid = strip_tags($bid);
  $bid = htmlspecialchars($bid);
 // select loggedin users detail
  //echo $userid;
  $query1 = "SELECT * from student_batch where student_id = $userid and batch_id = $bid";
 $res1=  mysqli_query($conn,$query1);
 //echo " show " . $res1;
 $courserow=mysqli_fetch_array($res1);
 $count = mysqli_num_rows($res1);
 if($count > 0) {
     $errMSG = "Oops ! Already Enrolled...";
 }
 else {
     mysqli_autocommit($conn, FALSE);
     $query = "insert into student_batch (student_id,batch_id)values ($userid,$bid)";
     $result=mysqli_query($conn,$query);
     if ($result) {
       $sql = "update batch set current_strength = current_strength + 1 where batch_id = $bid";
       $res = mysqli_query($conn, $sql);
       mysqli_commit($conn);
   
    $errTyp = "success";
    $errMSG = "Successfully Enrolled";
    
    //header("Location: home.php");
 }
 else {
     mysqli_rollback($conn);
     $errMSG = "Enrollment Failed try again later";
 }
 }
 echo "<script type='text/javascript'>
window.alert('$errMSG')
window.location.href='home.php';
</script>";
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
     $rolename = $_SESSION['role_name'];
     
     if ($rolename == "admin"){
         include ('adminmenu.php');
     } else {
        include('studentMenu.php'); 
     }
 ?>
 </div>
 <div id="main-content" style: border="0px;">
     <p> <h3>Greetings <?php echo $_SESSION['username']?> ,</h3></p> 
 <?php
 echo "<table width='50%' border='1'>";
echo "<tr>";
echo "<td width='50%>Course Name </td>";
echo "<td>" . $courserow['name'] . "</td></tr><tr>";
echo "<td>Fees</td>";
echo "<td>" . $courserow['fees'] . "</td>";
echo "<td>Start Date</td>";
echo "<td>" . $courserow['Start'] . "</td>";
echo "<td>End Date</td>";
echo "<td>" . $courserow['End'] . "</td>";

echo "</tr>";

echo "</table>";

 ?>
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
 
    </div>
     
<div id="mastfooter"><?php include('footer.html'); ?></div>
    </div>
    <!--script src="assets/jquery-1.11.3-jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script-->
    
</body>
</html>
<?php
mysqli_close($conn);
ob_end_flush(); ?>