

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
  //echo "session " . $_SESSION['cid'];
  
if (!empty($_SESSION['cid']))  {
    echo "selected  " . $cid;
    if (empty($cid)) {
        $cid = trim($_SESSION['cid']);
        $cid = strip_tags($cid);
        $cid = htmlspecialchars($cid);
    }
    else {
        $_SESSION['cid'] = $cid;
        echo "me " . $cid;
        //unset($_SESSION['bid']);
    }
}
else {
   //  unset($_SESSION['bid']);
}
//  echo $cid;
  $bid = trim($_POST['bselect']);
  $bid = strip_tags($bid);
  $bid = htmlspecialchars($bid); 
  
 /*
    if (empty($bid)) {
        $bid = trim($_SESSION['bid']);
        $bid = strip_tags($bid);
        $bid = htmlspecialchars($bid);
    }
    else {
        $_SESSION['bid'] = $bid;
    }
 */
  //echo $bid;
  
  
  $query = "SELECT * FROM Course c";
      //where c.course_id = '$cid'";

  $result = mysqli_query($conn,$query);
$numrows = mysqli_num_rows($result);
if ($numrows == 0) {
    $errMSG = "Error while getting Courses..";
}
else if (!empty($cid)) {
    $sql = "SELECT * FROM batch b where b.course_id = '$cid'";
    $res = mysqli_query($conn,$sql);
    $rowcount = mysqli_num_rows($res);
  }
  else {
      $res = "";
  }
  if (!empty($bid)) {
      $sql1 = "SELECT u.fname ,u.lname  FROM student_batch b, users u  where b.batch_id = $bid and b.student_id = u.userid;";
    $res1 = mysqli_query($conn,$sql1);
    $rowcount1 = mysqli_num_rows($res1);
  } else {
      $res1 = "";
      //$errMSG = "Please select a Batch";
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
    <h3>Report</h3>
</p>
<p><u> Batchwise Student List</u> </p>
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
                    <option value="0"></option>;
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
               if (!empty($res))
                if(mysqli_num_rows($res)){
                    $ct = 1;
                }
                ?>
                <div class="input-group">
                <!--span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span-->
                 Batch :<select class="form-control" name="bselect" placeholder="Select a Batch" onChange="this.form.submit();"> 
                    <option value="0"></option>;
<?php
    while($rs=mysqli_fetch_array($res)){
               if ($bid == $rs['batch_id']) {
        ?>
                    <option value="<?php echo $rs['batch_id'] ?>" selected><?php echo "batch " . $ct ?></option>;
                    <?php
        }else {
                        ?>
                    

      <option value="<?php echo $rs['batch_id'] ?>"><?php echo "batch " . $ct ?></option>;
      <?php
        }
      $ct++;
  }
?>
                 </select>
                 <span class="text-danger"><?php echo $bselectError; ?></span>
                </div>
         <div><br/></div>
     </div>
    </form> 
        
<?php
if (!empty($res1)) {
echo "<table border='1' width='50%'>
<tr>
<th width='100%' align='center'>Student Name</th></tr>";

while($rows = mysqli_fetch_array($res1))
{

echo "<tr>";
echo "<td>".$rows['fname']. " " . $rows['lname'] . "</td></tr>";
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