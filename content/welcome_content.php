
	<h1>Damavand Construction INC.</h1>
	<h3>Project Management</h3>
			<ul>
				<li>
					<button onclick='window.location.reload(true);' class="button button2">Home</button>
				</li>
			</ul>
		<p><b id="welcome">Welcome, <i><?php echo $_SESSION['username']; ?></i> (<a id="logout" href="logout.php">Log Out</a>)</b></p>
	<table>
			<tr>
				<th></th>
				<th></th>
			</tr>
			<tr>
			<td>
				<select id='dropdown' onchange="showProject(this.value)">
				<option value="">Select a Project </option>


				<?php
				if (strpos($_SESSION['username'], 'damavand') === false) #customer
				{
				$query = 'select projectID from project where customerID ='.$_SESSION['customerID'];
				$results = mysqli_query($connection, $query);
  				$row = mysqli_fetch_assoc($results);
				 echo '<option value="'.$row['projectID'].'">Project '.$row['projectID'].'</option>';
				}
				else
				{
					$query = 'select projectID from project';
					$results = mysqli_query($connection, $query);
  					while($drow = mysqli_fetch_assoc($results))
  					{
				 		echo '<option value="'.$drow['projectID'].'">Project '.$drow['projectID'].'</option>';
					}
				}?>
				</select>
			</td>
			<td>
			<?php
				if (strpos($_SESSION['username'], 'damavand') !== false)
				{

			?>
				<form action='createFunctionPage.php' method='POST'>
				
				<input type="hidden" id="type" name="type" value="Project">
				<input type='submit' value='Create Project'>
				</form>
			<?php
				}
			?>
			</td>
			</tr>
	</table>
	<div id="project-info">
		<div id="txtHint"><b>Project Information Will be Displayed Here</b></div>
		<div id="txtHint2"></div>
	</div>
