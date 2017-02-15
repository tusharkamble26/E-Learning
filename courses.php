

<!DOCTYPE html>
<html>
<head></head>
<body style="overflow-y: auto">
<p><h3> Welcome to Ritz Coaching </h3>
</p>
<p> Our Course List </p>

          
    <?php
ob_start();
 session_start();
 require_once 'dbconnect.php';
 
 // if session is not set this will redirect to login page
 $userid = "";
 if( !isset($_SESSION['user']) ) {
 /* header("Location: index.php");
  exit;*/
     
 }
 else {
     $userid = trim($_SESSION['user']);
 }
 
 $csearch = trim($_POST['csearch']);
  $csearch = strip_tags($csearch);
  $csearch = htmlspecialchars($csearch);
  if (empty($csearch) || isset($_POST['btn-reset'])) {
      $query = "SELECT * FROM Course";
  }
  else {
      $query = "SELECT * FROM Course where course_name like '%$csearch%'";
  }
$result = mysqli_query($conn,$query);
$numrows = mysqli_num_rows($result);
if ($numrows == 0) {
    $errMSG = "No Matching Courses ..";
}
?>
<div id="course_list">
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
             <div class="input-group">Search :
                <!--span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span-->
             <input type="text" name="csearch" class="form-control" placeholder="Search for a Course" maxlength="50"  />
             <button type="submit"  name="btn-search">Search</button>
             <button type="submit"  name="btn-reset">Reset</button>
                </div>
                <span class="text-danger"><?php echo $csearchError; ?></span>
            </div>
         <div><br/></div>
     </div>
    </form>
</div>
         
<?php
echo "<table border='1'>
<tr>
<th>Course Id </th>
<th>Course Name </th>
<th>Course Details </th>
<th>Course Fees (Rs)</th>
<th></th>
</tr>";

while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td>" . $row['course_id'] . "</td>";
echo "<td>" . $row['course_name'] . "</td>";
echo "<td>" . $row['course_details'] . "</td>";
echo "<td>" . $row['fees'] . "</td>";
echo "<td><a href=courseDetails.php?cid=" . $row['course_id'] . "&uid=" .$userid . ">Details </a></td>";
echo "</tr>";
}
echo "</table>";

mysqli_close($conn);
?>
</body>
