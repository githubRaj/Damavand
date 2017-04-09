<!DOCTYPE html>
<html>
<head>
 <link href="css/style.css" rel="stylesheet" type="text/css">
	<title>Tasks</title>
</head>
<body>

<table>
<tr><th>Payments For Tasks And Orders</th></tr>
<?php 
	require'connection.php';
	session_start();

	$counter = 0;
	if(@$_POST['id'] != "") #NEEDS FIXING, GET RID OF THE ARRAY
	{	
		$taskID = $_POST['id'][0];
		$phaseID = $_POST['id'][1];
		$projectID = $_POST['id'][2];
	}
	else
	{
		$taskID = $_SESSION['taskID'];
 	    $phaseID =  $_SESSION['phaseID'];
        $projectID = $_SESSION['projectID'];
	}

?>
<form action="taskAlterPayment.php" method="POST">
	<?php $alter = 1; #Add
		  $supplyID = 0; //No supplyID required
	?>
	<input type="hidden" id='superid' name="superid" value= <?php echo $supplyID ?>>
	 <input type="hidden" id='alter' name="alter" value= <?php echo $alter; ?>>
	 <input type="hidden" id='taskID' name="taskID" value= <?php echo $taskID; ?>>
	 <input type="hidden" id='phaseID' name="phaseID" value= <?php echo $phaseID; ?>>
	 <input type="hidden" id='projectID' name="projectID" value= <?php echo $projectID; ?>>
	<button type="submit" name="id" value=<?php echo 0; ?>>Add Task</button>
</form> 
<form action="OrderAlterPayment.php" method="POST">
	<?php $alter = 1; #Add
		  $supplyID = 0; //No supplyID required
	?>
	<input type="hidden" id='superid' name="superid" value= <?php echo $supplyID ?>>
	 <input type="hidden" id='alter' name="alter" value= <?php echo $alter; ?>>
	<button type="submit" name="id" value=<?php echo 0; ?>>Add Order</button>
</form> 
<tr><th>Task Payments</th></tr>
<?php 
	$query =  'SELECT paymentTASKID, supplierID, paid, totalAmount FROM paymentstask 
	WHERE projectID ="'.$projectID.'" AND phaseID = "'.$phaseID.'" AND taskID = "'.$taskID.'" ORDER BY paymentTASKID';
	$results = mysqli_query($connection, $query);
	while ($payment = mysqli_fetch_assoc($results)) {
		$counter++;
	?>
	<tr><td>
	<?php
		echo 'Payement ID: '.$counter;
	?>
	</tr></td>
	<tr><td>
	<?php
		echo 'Paid: '.$payment['paid'];
	?>
	</tr></td>
	<tr><td>
	<?php
		echo 'Total Amount: '.$payment['totalAmount'];
	?>
	</tr></td>
	<tr><td>
		<form action="taskAlterPayment.php" method="POST">
			<?php $alter = 2; #Modify?>
			 <input type="hidden" id='superid' name="superid" value= <?php echo $payment['supplierID']; ?>>
			  <input type="hidden" id='alter' name="alter" value= <?php echo $alter; ?>>
			   <input type="hidden" id='taskID' name="taskID" value= <?php echo $taskID; ?>>
			    <input type="hidden" id='phaseID' name="phaseID" value= <?php echo $phaseID; ?>>
			     <input type="hidden" id='projectID' name="projectID" value= <?php echo $projectID; ?>>
			<button type="submit" name="id" value=<?php echo $payment['paymentTASKID']; ?>>Modify</button>
		</form> 
		<form action="taskAlterPayment.php" method="POST">
			<?php $alter = 3; #Remove?>
			<input type="hidden" id='superid' name="superid" value= <?php echo $payment['supplierID']; ?>>
			  <input type="hidden" id='superid' name="superid" value= <?php echo $payment['supplierID']; ?>>
			  <input type="hidden" id='alter' name="alter" value= <?php echo $alter; ?>>
			   <input type="hidden" id='taskID' name="taskID" value= <?php echo $taskID; ?>>
			    <input type="hidden" id='phaseID' name="phaseID" value= <?php echo $phaseID; ?>>
			     <input type="hidden" id='projectID' name="projectID" value= <?php echo $projectID; ?>>
			<button type="submit" name="id" value=<?php $payment['paymentTASKID']; ?>>Remove</button>
		</form>
	</td></tr>
	<?php
	}
?>
	<tr><th>Order Payments</th></tr>
<?php
	$query =  'SELECT paymentOrderID, p.supplierID as supID, paid, totalAmount FROM paymentsorders p, orders o WHERE 
	p.orderID = o.orderID AND projectID = "'.$projectID.'" AND phaseID = "'.$phaseID.'" AND taskID = "'.$taskID.'"';
	$resultsOrder = mysqli_query($connection, $query);
	while($orderIds = mysqli_fetch_assoc($resultsOrder))
{
?>
<tr><td>
<?php
			echo 'OrderId: '.$orderIds['paymentOrderID'];
?>
</tr></td>
<tr><td>
<?php
		    echo 'Supplier ID: '.$orderIds['supID'];
?>
</tr></td>
<tr><td>
<?php
		    echo 'Paid: '.$orderIds['paid'];
?>
</tr></td>
<tr><td>
<?php
		    echo 'Total Amount: '.$orderIds['totalAmount'];
?>
</tr></td>
<tr><td>
		<form action="OrderAlterPayment.php" method="POST">
			<?php $alter = 2; #Modify?>
			 <input type="hidden" id='superid' name="superid" value= <?php echo $payment['supplierID']; ?>>
			  <input type="hidden" id='alter' name="alter" value= <?php echo $alter; ?>>
			<button type="submit" name="id" value=<?php echo $orderIds['paymentOrderID']; ?>>Modify</button>
		</form> 
		<form action="OrderAlterPayment.php" method="POST">
			<?php $alter = 3; #Remove?>
			<input type="hidden" id='alter' name="alter" value= <?php echo $payment['supplierID']; ?>>
			<button type="submit" name="id" value=<?php echo $orderIds['paymentOrderID']; ?>>Remove</button>
		</form>
	</td></tr>
<?php
}
	mysqli_free_result($results);
	mysqli_free_result($resultsOrder);
	mysqli_close($connection);
?>

</table>
</body>
</html>