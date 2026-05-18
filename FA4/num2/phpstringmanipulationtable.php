<!DOCTYPE html>
<html>
<head>
<title>PHP String Functions</title>
<style>
       body{
           font-family: Arial;
           background-color: #f2f2f2;
       }
       h1{
           text-align: center;
       }
       table{
           width: 95%;
           margin: auto;
           border-collapse: collapse;
           background-color: white;
           margin-top: 30px;
       }
       th, td{
           border: 1px solid black;
           padding: 12px;
           text-align: center;
       }
       th{
           background-color: #dddddd;
       }
</style>
</head>
<body>
<h1>PHP String Functions Activity</h1>
<?php
$names = array(
   "chrisa",
   "mathew",
   "aaron",
   "brian",
   "charles",
   "daniel",
   "ethan",
   "francis",
   "gabriel",
   "henry",
   "ivan",
   "jacob",
   "kevin",
   "leo",
   "mark",
   "nathan",
   "owen",
   "paul",
   "ryan",
   "steven"
);
?>
<table>
<tr>
<th colspan="6">List of Names</th>
</tr>
<tr>
<th>Name</th>
<th>Number of Characters</th>
<th>Uppercase First Character</th>
<th>Replace Vowels with @</th>
<th>Check Position of "a"</th>
<th>Reverse Name</th>
</tr>
<?php
for($i = 0; $i < count($names); $i++){
   $name = $names[$i];
   $length = strlen($name);
   $uppercase = ucfirst($name);
   $replace = str_replace(
       array('a','e','i','o','u','A','E','I','O','U'),
       '@',
       $name
   );
   $position = strpos($name, "a");
   if($position !== false){
       $position = $position + 1;
   }else{
       $position = "Not Found";
   }
   $reverse = strrev($name);
   echo "<tr>";
   echo "<td>$name</td>";
   echo "<td>$length</td>";
   echo "<td>$uppercase</td>";
   echo "<td>$replace</td>";
   echo "<td>$position</td>";
   echo "<td>$reverse</td>";
   echo "</tr>";
}
?>
</table>
</body>
</html>