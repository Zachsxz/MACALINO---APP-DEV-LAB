<!DOCTYPE html>
<html>
<head>
<title>Question 2 - Using Arrays</title>
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
<h2>Using ARRAYS</h2>
<?php
$numbers = array(1,2,3,4,5,6,7,8,10);
// ADDITION
$addition = 0;
foreach($numbers as $num){
   $addition += $num;
}
// SUBTRACTION
$subtraction = $numbers[0];
for($i = 1; $i < count($numbers); $i++){
   $subtraction -= $numbers[$i];
}
// MULTIPLICATION
$multiplication = 1;
foreach($numbers as $num){
   $multiplication *= $num;
}
// DIVISION
$division = $numbers[0];
for($i = 1; $i < count($numbers); $i++){
   $division /= $numbers[$i];
}
?>
<table>
<tr>
<th colspan="2">
           Array List:
<?php echo implode(", ", $numbers); ?>
</th>
</tr>
<tr>
<td>Addition</td>
<td><?php echo $addition; ?></td>
</tr>
<tr>
<td>Subtraction</td>
<td><?php echo $subtraction; ?></td>
</tr>
<tr>
<td>Multiplication</td>
<td><?php echo $multiplication; ?></td>
</tr>
<tr>
<td>Division</td>
<td><?php echo $division; ?></td>
</tr>
</table>
</body>
</html>