<!DOCTYPE html>
<html>
<head>
<title>Add Payment</title>
</head>
<body>
  <?php session_start(); 
  require'connection.php';

  $alterType = $_POST['alter'];
  $paymentTaskID = $_POST['id'];
  $SupplierID = $_POST['superid'];


  $_SESSION['paymentTaskID'] = $paymentTaskID;

  $taskID = $_POST['taskID'];
  $phaseID = $_POST['phaseID'];
  $projectID = $_POST['projectID'];

  $_SESSION['taskID'] = $taskID;
  $_SESSION['phaseID'] = $phaseID;
  $_SESSION['projectID'] = $projectID;

  if($alterType == 1) #Add
  {

  ?>

  <form action="/Damavand/taskInsertpayment.php" method="POST">
  Paid: <input type="text" id="paid" name="paid"><br><br>
  Total Amount: <input type="text" id="ttlAmnt" name="ttlAmnt"><br><br>
  SupplierID: <input type="text" id="supID" name="supID"><br><br>
  <button type="submit" name="altertype" value="1">Add</button>
</form>
  <?php
  }
  else if( $alterType == 2){
  $query =  'select paid, totalAmount from paymentstask where projectID ="'.$projectID.'"
      AND taskID ="'.$taskID.'" AND phaseID ="'.$phaseID.'" AND paymentTaskID ="'.$paymentTaskID.'"';
  $results = mysqli_query($connection, $query);
  $row = mysqli_fetch_assoc($results);
  print_r($query);
  ?>
  <form action="/Damavand/taskInsertpayment.php" method="POST">
  Paid: <input type="text" name="paid" value=<?php echo $row['paid']; ?>><br><br>
  Total Amount: <input type="text" name="ttlAmnt" value=<?php echo $row['totalAmount']; ?>><br><br>
  <input type="hidden" id='superid' name="superid" value= <?php echo $SupplierID; ?>>
  <button type="submit" name="altertype" value="2">Modify</button>
  </form>
  <?php
  }
  else
  {
    $query =  'DELETE FROM paymentstask where paymentTaskID ="'.$paymentTaskID.'"';
    $connection->query($query);
  }
  ?>

</form>
</body>
</html>