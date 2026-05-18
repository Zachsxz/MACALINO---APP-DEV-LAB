<!DOCTYPE html>
<html>
<head>
<title>User Defined Function</title>
<style>
       body{
           font-family: Arial;
           background-color: #f4f4f4;
           padding: 30px;
       }
       h2{
           text-align: center;
       }
       table{
           width: 700px;
           margin: auto;
           border-collapse: collapse;
           background-color: white;
       }
       th, td{
           border: 1px solid black;
           padding: 12px;
           text-align: center;
       }
       th{
           background-color: lightgray;
       }
</style>
</head>
<body>
<h2>USING USER DEFINED FUNCTION</h2>
<?php
function myFunction($param1, $param2, $param3){
   $addition = $param1 + $param2 + $param3;
   $subtraction = $param1 - $param2 - $param3;
   $multiplication = $param1 * $param2 * $param3;
   $division = $param1 / $param2 / $param3;
   echo "<table>";
   echo "<tr>";
   echo "<th colspan='2'>";
   echo "My Parameter Values: $param1, $param2, $param3";
   echo "</th>";
   echo "</tr>";
   echo "<tr>";
   echo "<td>Addition</td>";
   echo "<td>$addition</td>";
   echo "</tr>";
   echo "<tr>";
   echo "<td>Subtraction</td>";
   echo "<td>$subtraction</td>";
   echo "</tr>";
   echo "<tr>";
   echo "<td>Multiplication</td>";
   echo "<td>$multiplication</td>";
   echo "</tr>";
   echo "<tr>";
   echo "<td>Division</td>";
   echo "<td>$division</td>";
   echo "</tr>";
   echo "</table>";
}
myFunction(25, 13, 6);
?>
</body>
</html>