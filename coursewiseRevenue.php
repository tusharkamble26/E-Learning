

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

 $cid = trim($_POST['cselect']);
  $cid = strip_tags($cid);
  $cid = htmlspecialchars($cid);
  
  
 // echo $cid;
  
  
  $query = "SELECT * FROM Course c";
      //where c.course_id = '$cid'";

  $result = mysqli_query($conn,$query);
$numrows = mysqli_num_rows($result);
$values = mysqli_query($conn, $query);
if ($numrows == 0) {
    $errMSG = "Error while getting Courses..";
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
    <h3>Report</h3>
</p>
<p><u> Course wise Generated Revenue</u> </p>
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
      //          $sql= "Select course_id, course_name from course";
        //        $values = mysqli_query($conn,$sql);
                if(mysqli_num_rows($result)){
                    ?>
             <div class="input-group">
                <!--span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span-->
                Course : <select class="form-control" name="cselect" placeholder="Select a Course" onChange="this.form.submit();"> 
                    <option value="0">All Courses</option>;
<?php
    while($rs=mysqli_fetch_array($result)){
        if ($cid == $rs['course_id']) {
        ?>
                    <option value="<?php echo $rs['course_id'] ?>" selected><?php echo $rs['course_name'] ?></option>;
                    <?php
        }else {
                        ?>
                    
      <option value="<?php echo $rs['course_id'] ?>"><?php echo $rs['course_name'] ?></option>;
      <?php
                    }
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
//if (!empty($res)) {

$total = 0;
 if ($cid <> 0) {
    $sql = "SELECT count(sb.student_id) * c.fees  AS amount FROM student_batch sb, course c, batch b 
where c.course_id = $cid and sb.batch_id = b.batch_id and b.course_id = c.course_id;";
    $res = mysqli_query($conn,$sql);
    $rowcount = mysqli_num_rows($res);
    echo "<table border='1' width='50%'>
<tr>
</tr>";
    while($rows = mysqli_fetch_array($res))
{
$total += $rows['amount'];
echo "<tr>";
echo "<td width='50%' align='center'>Revenue Generated (Rs)</th>";
echo "<td>" . $rows['amount'] . "</td></tr>";
}
echo "</table>";
echo "<br/>";
echo "<table border='0' <tr><td width = '70%'>Total Revenue (Rs)</td><td>";
echo " .$total .</td></tr></table>";
}
  
  else {
      echo "<table border='1' width='100%'>
<tr>
</tr>";
      while ($cr = mysqli_fetch_array($values)) {
          $cid = $cr['course_id'];
           $sql = "SELECT count(sb.student_id) * c.fees  AS amount FROM student_batch sb, course c, batch b 
where c.course_id = $cid and sb.batch_id = b.batch_id and b.course_id = c.course_id;";
    $res = mysqli_query($conn,$sql);
    $rowcount = mysqli_num_rows($res);
    //echo $rowcount;
      
while($rows = mysqli_fetch_array($res))
{
$total += $rows['amount'];
echo "<tr>";
echo "<td width='50%' align='center'>" . $cr['course_name'] . " - Revenue Generated (Rs)</th>";
echo "<td>" . $rows['amount'] . "</td></tr>";
}

      }
      echo "</table>";
echo "<br/>";
echo "<table border='0' <tr><td width = '70%'>Total Revenue (Rs)</td><td>";
echo " .$total .</td></tr></table>";
}
mysqli_close($conn);
?>
    </div>
</div>
<div id="mastfooter"><?php include('footer.html'); ?></div>
    </div>
</body>
</html>