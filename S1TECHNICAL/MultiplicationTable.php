<!DOCTYPE html>
<html>
<head>
<title>Multiplication Table</title>
<style>
       table{
           border-collapse: collapse;
       }
       td{
           width: 50px;
           height: 50px;
           text-align: center;
           border: 1px solid black;
           font-size: 20px;
       }
       .green{
           background-color: green;
       }
       .yellow{
           background-color: yellow;
       }
</style>
</head>
<body>
<h1>Multiplication Table</h1>
<table>
<?php
for($row = 1; $row <= 10; $row++)
{
   echo "<tr>";
   for($col = 1; $col <= 10; $col++)
   {
       $answer = $row * $col;
       if(($row + $col) % 2 == 0)
       {
           $color = "green";
       }
       else
       {
           $color = "yellow";
       }
       echo "<td class='$color'>$answer</td>";
   }
   echo "</tr>";
}
?>
</table>
</body>
</html>