<head>
  <link href="css/style.css" rel="stylesheet" type="text/css">
  <script src="js/lib/jquery-validation-1.16.0/lib/jquery-3.1.1.js"></script>
  <script src="js/lib/jquery-validation-1.16.0/dist/jquery.validate.js"></script>
<script>
$(document).ready(function(){
    $(document.getElementById("itemButton")).click(function(){
        $(document.getElementById("form2")).clone().appendTo("body");
    });
});
</script>
</head>
<div id='items-main' class='center'>
    <?php

    /*=================================================================
            FILE TO INSERT PROJECTS, Orders AND ITEMS
    =================================================================*/
    require 'connection.php';
    session_start();
    $count = 0;
    $type = $_POST['type'];
    $_SESSION['type'] = $type;
    $projectID = ['projectID'];
    //$phaseID = $_POST['phaseID'];

    if($type=='Project'){
        $sql="SELECT projectName as 'Project Name', projectManagerID as 'Project Manager ID', customerID as 'Customer ID', startDate as 'Start Date', endDate as 'End Date', siteAddress as 'Address', status as 'Status', estimatedCost as 'Estimated Cost', actualCost as 'Actual Cost' FROM Project ORDER BY projectID ASC LIMIT 1";
    }else if($type=='Order'){
        $sql="SELECT projectID as 'Project Number', phaseID as 'Phase Number', taskID as 'Task Number', supplierID as 'Supplier ID', totalCost as 'Total Cost', orderDate as 'Order Date', estimatedDeliveryDate as 'Estimated Delivery Date' FROM Orders ORDER BY orderID ASC LIMIT 1";
       // $sql2="SELECT itemID as 'Item ID',  itemName as 'Item Name', unitCost as 'Unit Cost', quantity as 'Quantity', orderID as 'Order Number', supplierID as 'Supplier ID' FROM Items ORDER BY itemID ASC LIMIT 1";


    /*$result2 = mysqli_query($connection,$sql);
    $fieldCount2 = mysqli_num_fields($result2);
    $fields2 = mysqli_fetch_fields($result2);
    $fieldArray2 = array();
    $fieldOrig2 = array();   //original table name
    $fieldType2 = array();

    while($fields=mysqli_fetch_field($result2)) {
        $fieldArray2[$count] = $fields->name;
        $fieldOrig2[$count] = $fields->orgname;      //name within tables
        $fieldType2[$count] = $fields->type;
        $count ++;
    }
*/
    }else if($type=='Item'){
    	$sql2="SELECT  orderID as 'Order Number' FROM Orders ORDER BY orderID ASC";
    	$sql="SELECT itemName as 'Item Name', unitCost as 'Unit Cost', quantity as 'Quantity', supplierID as 'Supplier ID' FROM Items ORDER BY itemID ASC LIMIT 1";
    }
    
    $result = mysqli_query($connection,$sql);
    $fieldCount = mysqli_num_fields($result);
    $fields = mysqli_fetch_fields($result);
    $numRows = mysqli_num_rows($result);
    $fieldArray = array();
    $fieldOrig = array();   //original table name
    $valueArray = array();
    $fieldType = array();
    $count = 0;

    //store attribute Name and type
    while($fields=mysqli_fetch_field($result)) {
        $fieldArray[$count] = $fields->name;
        $fieldOrig[$count] = $fields->orgname;      //name within tables
        $fieldType[$count] = $fields->type;
        $count ++;
    }

    //get column nullable or not
    //column metadata is in information_schema database, change dbs temporarily
    $sql3 = "SELECT column_name, is_nullable FROM INFORMATION_SCHEMA.COLUMNS
             where table_schema = 'ctc353_4'
             and table_name = '$type'";
    $result = mysqli_query($connection, $sql3);
    var_dump($result);
    $fieldsNullable=mysqli_fetch_fields($result);
    $fieldNullable = array();
    //$countNullable = 0;

    while($fieldsNullable=mysqli_fetch_field($result)) {
        $row = mysqli_fetch_assoc($result);
        $fieldNullable[$row['column_name']] = $row['is_nullable'] == 'NO' ? false : true;
        //$countNullable ++;
    }
    var_dump($fieldNullable);

    echo "</tr>";
    echo "<tr>";

    //print_r($fieldType);
    echo '<h1>Damavand Construction INC.</h1>';
    echo '<h3>Create '.$type.'</h3>';  
    
    if($type=='Project'){
       echo "<ul>
        <li>
            <button  onclick=\"location.href ='Welcome.php';\" class=\"button button2\">Home</button>
            >>
            <button onclick=\"location.href ='projectDetails.php';\" class=\"button button2\">Create Project  </button> 
        </li>
    </ul>";
    }else if($type=='Order'){
       echo "<ul>
        <li>
            <button onclick=\"location.href ='Welcome.php';\" class=\"button button2\">Home</button>
            >>
           <button onclick='window.location.reload(true);' class=\"button button2\">Create New Order</button>
        </li>
    </ul>";
    }
    else if ($type == 'Item')
    {
         echo "<ul>
                <li>
                    <button  onclick=\"location.href ='Welcome.php';\" class=\"button button2\">Home</button>
                    >>
                     <button onclick='window.location.reload(true);' class=\"button button2\">Create New Item</button>    
                </li>
            </ul>";
    }


    echo '<form id="form1" name="form1" action="createFunction.php" method="POST">';
    echo 
    "<table id='modifyTable'>
        <tr>
            <th>Attribute Names</th>
            <th>Values</th>
            <th></th>
        </tr>";
    for($x = 0; $x < $fieldCount; $x++){
        echo "<tr>";
        //Decide Input type
        $inputType ="";
        switch ($fieldType[$x]) {
            case "3":                                       //Integer
            case "253":                                     //VarChar
            case "246":                                     //Decimal
                $inputType = '<input type="text" ';
                break;
            case "10":                                      //Date
                $inputType = '<input type="Date" ';      
        }
        echo "<td>".$fieldArray[$x]."</td>";
        echo "<td>".$inputType." id=".$fieldOrig[$x]." name=".$fieldOrig[$x].">"."</td>";
        echo "</tr>";
    }
    $addOn = "";
    if($type=='Item'){
        $addOn =" Add to Order: <select name='OrderID' id='OrderID'>";
        $result = mysqli_query($connection,$sql2);
        while($row = mysqli_fetch_array($result)) {
            $addOn .= "<option id=oid name=oid value=".$row['Order Number'].">Order Number ".$row['Order Number']."</option>";
        }
        $addOn .= "</select>";
    }
    echo '<tr> <td><input id="submit" type="submit" value="Submit"><input id="submit" type="submit" value="Cancel">'.$addOn.'</td>';
    echo "</table>";
    echo '</form>';
    mysqli_close($connection);
    ?>
</div>
