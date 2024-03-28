<?php

////// Write the Database connection code below (Q1)
$servername = 'localhost'; //for XAMPP we use localhost
  $username = 'root'; //default username in XAMPP
  $password = ''; //default password in XAMPP
  $dbname = 'Project3'; //Change this to whatever database name you set in PHPmyAdmin
$link = mysqli_connect($servername,$username,$password, $dbname);
if (mysqli_connect_error())
{
  die("Database connection is unsuccessful");

}
else 
{
  echo "Database connection is successful";
};


///////// (Q1 Ends)

$operation_val = '';
if (isset($_POST['operation']))
{
  $operation_val = $_POST["operation"];
  #echo $operation_val;
}

function getId($link) {
  
  $queryMaxID = "SELECT MAX(id) FROM fooditems;";
  $resultMaxID = mysqli_query($link, $queryMaxID);
  $row = mysqli_fetch_array($resultMaxID, MYSQLI_NUM);
  return $row[0]+1;
}



if (isset($_POST['updatebtn']))
{//// Write PHP Code below to update the record of your database (Hint: Use $_POST) (Q9)
//// Make sure your code has an echo statement that says "Record Updated" or anything similar or an error message
  
$record_id = $_POST['id'];
$record_amount = $_POST['amount'];
$record_calories = $_POST['calories'];
$sql = "UPDATE $fooditems SET amount = $record_amount, calories = $record_calories WHERE id = $record_id";

$result = mysqli_query($link, $sql);
echo "Record Updated";
//watch update/insert sql videos//
//// (Q9 Ends)
}


if (isset($_POST['insertbtn']))
{//// Write PHP Code below to insert the record into your database (Hint: Use $_POST and the getId() function from line 25, if needed) (Q10)
//// Make sure your code has an echo statement that says "Record Saved" or anything similar or an error message
  
// watch insert sql 

$insert_item = $_POST['item'];
$insert_amount = $_POST['amount'];
$insert_unit = $_POST['unit'];
$insert_calories = $_POST['calories'];
$insert_protein = $_POST['protein'];
$insert_carbohydrates = $_POST['carbohydrates'];
$insert_fat = $_POST['fat'];
$getId = getId($link);
echo "Record saved";

//// (Q10 Ends)
}


if (isset($_POST['deletebtn']))
{//// Write PHP Code below to delete the record from your database (Hint: Use $_POST) (Q11)
//// Make sure your code has an echo statement that says "Record Deleted" or anything similar or an error message
 $deleteid = $_POST['deleteid'];
$sql = "DELETE FROM fooditems WHERE id = $deleteid";
$result = mysqli_query($link, $sql);
echo "Record deleted";
//// (Q11 Ends)
}



?>


<html>
  <head>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
      <link rel="stylesheet" href="p3.css">
      <script>
          $(document.ready(function() {
              $("#testbtn").click(function(e) {
                  e.preventDefault();

                  $.ajax({
                      url: 'p3.php',
                      type: 'POST',
                      data: {
                          'operation_val' : $("#operation_val").val(),
                      },
                      success: function(data, status) {
                          $("#test").html(data)
                      }
                  });
              });
              $("#insertbtn").click(function(e) 
              {
                  //echo "here0";
                  e.preventDefault();

                  $.ajax({
                      url: 'p3.php',
                      type: 'POST',
                      data: {
                          'operation_val' : $("#operation_val").val(),
                      },
                      success: function(data, status) {
                      //    echo"here";
                      }
                  });
              });
          }));
          
          
      </script>
  </head>

  <body>

      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <label for="cars">Choose an operation:</label>
          <select name="operation" id="operation" onchange="this.form.submit()">
              <option value="0" <?php print ($operation_val == 0) ? "selected" : '' ;?>><b>Select Operation</b></option>
              <option value="1" <?php print ($operation_val == 1) ? "selected" : '' ;?>>Show</option>
              <option value="2" <?php print ($operation_val == 2) ? "selected" : '' ;?>>Update</option>
              <option value="3" <?php print ($operation_val == 3) ? "selected" : '' ;?>>Insert</option>
              <option value="4" <?php print ($operation_val == 4) ? "selected" : '' ;?>>Delete</option>
          </select></br></br>
          <?php


          $query = "SELECT * FROM fooditems;";
          if($operation_val == 1){
              if($result = mysqli_query($link, $query)){
                  $fields_num = mysqli_num_fields($result);
                  echo "<table class=\"customTable\"><th>";
                  for($i=0; $i<$fields_num; $i++)
                  {
                      $field = mysqli_fetch_field($result);
                      if($i>0)
                      {
                          echo "<th>{$field->name}</th>";
                      }
                      else
                      {
                          echo "id";
                      }
                      
                  }
                  echo "</th>";
                  if($operation_val == 1){
                      while($row = mysqli_fetch_row($result))
                      {
                          ///// Finish the code for the table below using a loop (Q2)
                          echo "<tr>";
                              foreach($row as $cell)
                              {
                                  echo "<td> $cell</td>";
                              }
                          echo "</tr>";
                          ///////////// (Q2 Ends)
                      }
                  }                    
                  echo "</table>";
          }
      }
          

          ?>

          


          <div id="div_update" runat="server" class=<?php if($operation_val == 2) {echo "display-block";} else {echo "display-none";}?>>
          <!--Create an HTML table below to enter ID, amount, and calories in different text boxes. This table is used for updating records in your table. (Q3) --->
          <table border="1">
              <thead>
                  <tr>
                      <th>ID</th>
                      <th>Amount</th>
                      <th> Calories</th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                      <td><input type="text" name="id" id="id"></td> 
                      <td><input type="text" name="amount" id="amount"></td>
                      <td><input type="text" name="calories" id="calories"></td>
                   </tr>
              </tbody>
          </table>


          <!--(Q3) Ends --->
          



          <!--Create a button below to submit and update record. Set the name and id of the button to be "updatebtn"(Q4) --->
          <button type="button" name="updatebtn" id="updatebtn">Submit and Update Record</button>

          <!--(Q4) Ends --->
          </div>



          <div id="div_insert" runat="server" class=<?php if($operation_val == 3) {echo "display-block";} else {echo "display-none";}?>>
          <!--Create an HTML table below to enter item, amount, unit, calories, protein, carbohydrate and fat in different text boxes. This table is used for inserting records in your table. (Q5) --->
              
           <div class=CustomTable>
          <h2>Enter Item Details</h2>
              <table>
              <tr>
                  <th>Item</th>
                  <th>Amount</th>
                  <th>Unit</th>
                  <th>Calories</th>
                  <th>Protein (g)</th>
                  <th>Carbohydrate (g)</th>
                  <th>Fat (g)</th>
              </tr>
              <tr>
                  <td><input type="text" id="Items"></td>
                  <td><input type="text" id="Amounts"></td>
                  <td><input type="text" id="Units"></td>
                  <td><input type="text" id="Calories"></td>
                  <td><input type="text" id="Protein"></td>
                  <td><input type="text" id="Carbohydrates"></td>
                  <td><input type="text" id="Fats"></td>
              </tr>
              </table>
          <!--(Q5) Ends --->
          <!--Create a button below to submit and insert record. Set the name and id of the button to be "insertbtn"(Q6) --->
          <button type="button" name="insertbtn" id="insertbtn">Submit and Insert Record</button>
          <!--(Q6) Ends --->
          </div>

          <div id="div_delete" runat="server" class=<?php if($operation_val == 4) {echo "display-block";} else {echo "display-none";}?>>
          <!--Create an HTML table below to enter id a text box. This table is used for deleting records from your table. (Q7) --->
          <table>
            <tr>
               <th>ID</th>
              <th>Action</th>
            </tr>
       <tr>
           <td><input type="text" name="id" id = "deleteid"></td>
       </tr>
          </table>
          <!--(Q7) Ends--->    
          <!--Create a button below to submit and insert record. Set the name and id of the button to be "deletebtn"(Q8) --->
          <button type="button" name="deletebtn" id="deletebtn">Delete</button>
          <!--(Q8) Ends --->
          </div>
          
      </form>

  </body>




</html>
