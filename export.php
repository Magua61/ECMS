<?php  
// database
/** @var $pdo \PDO */
require_once "database.php";
include('session.php');

$output = '';
if(isset($_POST["export"]))
{
 $query = "CALL viewEvacuee";
 $result = mysqli_query($connect, $query);
 if(mysqli_num_rows($result) > 0)
 {
  $output .= '
   <table class="table" bordered="1">  
                    <tr>  
                         <th>Evacuee_ID</th>  
                         <th>First_Name</th>  
                         <th>Last_Name</th>  
                        <th>Age</th>
                        <th>Household_ID</th>
                    </tr>
  ';
  while($row = mysqli_fetch_array($result))
  {
   $output .= '
                    <tr>  
                         <td>'.$row["Evacuee_ID"].'</td>  
                         <td>'.$row["First_Name"].'</td>  
                         <td>'.$row["Last_Name"].'</td>  
                        <td>'.$row["Age"].'</td>  
                        <td>'.$row["Household_ID"].'</td>
                    </tr>
   ';
  }
  $output .= '</table>';
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=download.xls');
  echo $output;
 }
}
?>