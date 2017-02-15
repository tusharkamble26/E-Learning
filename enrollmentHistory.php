

<!DOCTYPE html>
<html>


          
    <?php
ob_start();
 session_start();
 require_once 'dbconnect.php';
 
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
//echo $userid;
 //echo $_POST['cselect'];
$error = false;

 
  
 // echo $cid;
  
  
  $query = "select c.course_name,b.startdate,b.enddate from course c, student_batch sb, batch b
where sb.student_id = $userid and c.course_id = b.course_id and b.batch_id = sb.batch_id ;";
      //where c.course_id = '$cid'";

  $result = mysqli_query($conn,$query);
$numrows = mysqli_num_rows($result);

if ($numrows == 0) {
    $errMSG = "No Enrollment History..";
}

      
     // $res = "";
//  }
  
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
<p><u>  Student Enrollment history</u> </p>
<div id="course_hist">
   <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
    
     <div class="col-md-12">
        
            
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
        
<?php
//if (!empty($res)) {

$i = 1;
      echo "<table border='1' width='100%'>
<tr>
<th>S No</th>
<th width='50%' align='center'>Course Name</th>
<th>Start Date</th>
<th>End Date</th>
</tr>";
      while ($rows = mysqli_fetch_array($result)) {
          

echo "<tr>";
echo "<td>" . $i . "</td>";
echo "<td width='50%' align='center'>" . $rows['course_name'] . "</th>";
echo "<td>" . date('Y-m-d',  strtotime($rows['startdate'])) . "</td>";
    echo "<td>" . date('Y-m-d',  strtotime($rows['enddate'])) . "</td>
</tr>";
    $i++;
}


      echo "</table>";
echo "<br/>";

mysqli_close($conn);
?>
    </div>
</div>
<div id="mastfooter"><?php include('footer.html'); ?></div>
    </div>
</body>
</html>