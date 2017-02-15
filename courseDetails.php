

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
 /* header("Location: index.php");
  exit;*/
     
 }
 else {
     $userid = trim($_SESSION['user']);
     $rolename = $_SESSION['rolename'];
 }
//echo $userid;
 //echo $_POST['cselect'];
$error = false;

 $cid = trim($_GET['cid']);
  $cid = strip_tags($cid);
  $cid = htmlspecialchars($cid);
  
  $uid = trim($_GET['uid']);
  $uid = strip_tags($uid);
  $uid = htmlspecialchars($uid); 
  if (empty($cid)) {
     $cid = trim($_POST['cselect']);

  $cid = strip_tags($cid);
  $cid = htmlspecialchars($cid);
  
  //echo $cid;
  }
  if (!empty($cid)) {
  $query = "SELECT * FROM Course c where c.course_id = '$cid'";

  $result = mysqli_query($conn,$query);
$numrows = mysqli_num_rows($result);
if ($numrows == 0) {
    $errMSG = "Error while getting Course Details or No Course Selected..";
}
else {
    $sql = "SELECT * FROM batch b where b.course_id = '$cid'";
    $res = mysqli_query($conn,$sql);
    $rowcount = mysqli_num_rows($res);
  }}
  else {
      $errMSG = "Please select a course";
  }
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
    <p><h3> Welcome to Ritz Coaching </h3>
</p>
<p><u> Course Details</u> </p>
<div id="course_det">
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
            
            <div class="form-group">
             <?php 
                $sql= "Select course_id, course_name from course";
                $values = mysqli_query($conn,$sql);
                if(mysqli_num_rows($values)){
                    ?>
             <div class="input-group">
                <!--span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span-->
                 <select class="form-control" name="cselect" placeholder="Select a Course" onChange="this.form.submit();"> 
                    <option value="0"></option>;
<?php
    while($rs=mysqli_fetch_array($values)){
        ?>
      <option value="<?php echo $rs['course_id'] ?>"><?php echo $rs['course_name'] ?></option>;
      <?php
  }
?>
                 </select>
                 <span class="text-danger"><?php echo $cselectError; ?></span>
                </div>
                <?php 
                }
                ?>
                
         <div><br/></div>
     </div>
    </form> 
        
<?php

if (!empty($result))
while($row = mysqli_fetch_array($result))
{
    echo "<table border='0'>";
echo "<tr>";
echo "<td width='25%'>Course Name : </td><td>" . $row['course_name'] . "</td></tr>";
echo "<tr><td width='25%'>Course Details :</td><td>" . $row['course_details'] . "</td>";
echo "<tr><td width='25%'>Course Fees :</td><td>" . $row['fees'] . "</td></tr>";
echo "</tr>";
}
echo "</table>";
echo "<br/>";
if ($rowcount > 0){
echo "<table border='1'>
<tr>
<th width='10%'>Batch </th>
<th width='15%'>Start Date </th>
<th width='15%'>End Date </th>
<th width='12%'>Batch Size</th>
<th width='12%'>Total Hrs</th>
<th width='12%'>Availability</th>
<th width='25%'>Schedule</th>
<th></th>
</tr>";
$i=1;
$isSeat = "";
while($rows = mysqli_fetch_array($res))
{
    if ($rows[batchsize] > $rows[current_strength]) {
        $isSeat= "Yes";
    }
    else {
        $isSeat = "No";
    }
echo "<tr>";
echo "<td>Batch " . $i . "</td>";
echo "<td>" . date('Y-m-d',  strtotime($rows['startdate'])) . "</td>";
echo "<td>" . date('Y-m-d',  strtotime($rows['enddate'])) . "</td>";
echo "<td>" . $rows['batchsize'] . "</td>";
echo "<td>" . $rows['hours_per_day'] . "</td>";
echo "<td>" . $isSeat . "</td>";
echo "<td>" . $rows['schedule'] . "</td>";
if ($isSeat == "Yes" && $rolename == "Student")
    echo "<td><a href=enroll.php?cid=" . $rows['course_id'] . "&bid=" .$rows['batch_id'] . ">Enroll </a></td>";
echo "</tr>";
$i = $i + 1;
}
echo "</table>";
echo "<br/>";

}
mysqli_close($conn);
?>
    </div>
</div>
<div id="mastfooter"><?php include('footer.html'); ?></div>
    </div>
</body>
</html>
<?php ob_end_flush(); ?>