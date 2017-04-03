<div id='modify-phase-main' class='center'>
  
  <?php
  require'connection.php';
  session_start();

  $phaseID = $_SESSION['phaseID'];
  $projectID = $_SESSION['projectID'];  //DOESNT WORK

  $_SESSION['phaseID'] = $phaseID;
  $_SESSION['pID'] = $projectID; #not needed if the hidden PID works

    $query =  'select taskName, estimatedCost, actualCost, estimatedStartDate, estimatedEndDate, actualStartDate,
    actualEndDate, status from Phase where projectID ="'.$projectID.'" AND phaseID = "'.$phaseID.'"';
    $results = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($results);

  ?>
    <h1>Damavand Construction INC.</h1>
    <h3>Modify Project <?php echo $projectID.' Phase '.$phaseID ?></h3>
    <form action="modifiedPhase.php" method="POST">
      <input type="hidden" name="PID" id="PID" value=<?php echo $projectID ?>/> <!--  THIS DOESNT WORK   -->
      <table id='modify-phase-table' class='center'>
        <tr>
          <td>Phase Name: </td>
          <td><input type="text" name="phaseName" value=<?php echo $row['taskName']?>></td>
        </tr>
        <tr>
          <td>Estimated Cost: </td>
          <td><input type="text" name="estCost" value=<?php echo $row['estimatedCost']?>></td>
        </tr>
        <tr>
          <td>Actual Cost: </td>
          <td><input type="text" name="actualCost" value=<?php echo $row['actualCost']?>></td>
        </tr>
        <tr>
          <td>Estimated Start Date: </td>
          <td><input type="date" name="estStartDate" value="<?php echo date('Y-m-d',strtotime($row['estimatedStartDate'])) ?>"></td>
        </tr>
        <tr>
          <td>Estimated End Date: </td>
          <td><input type="date" name="estEndDate" value="<?php echo date('Y-m-d',strtotime($row['estimatedEndDate'])) ?>"></td>
        </tr>
        <tr>
          <td>Actual Start Date: </td>
          <td><input type="date" name="actualStartDate" value="<?php echo date('Y-m-d',strtotime($row['actualStartDate'])) ?>"></td>
        </tr>
        <tr>
          <td>Actual End Date: </td>
          <td><input type="date" name="actualEndDate" value="<?php echo date('Y-m-d',strtotime($row['actualEndDate'])) ?>"/></td>
        </tr>
        <tr>
          <td>Current Status (Complete, In Progress, Not Started): </td>
          <td><input type="text" name="status" value=<?php echo $row['status']?>/></td>
        </tr>
        <tr>
          <td colspan="2"><input type="submit" value="Submit"></td>
        </tr>
      </table>
  </form>
</div>
