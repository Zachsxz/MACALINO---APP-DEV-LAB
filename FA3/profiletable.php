<!DOCTYPE html>
<html>
<head>
<title>Using Arrays</title>
<style>
       body{
           font-family: Arial, sans-serif;
           background-color: #f2f2f2;
       }
       h2{
           text-align: center;
       }
       table{
           width: 90%;
           margin: auto;
           border-collapse: collapse;
           background-color: white;
       }
       th, td{
           border: 1px solid black;
           padding: 10px;
           text-align: center;
       }
       th{
           background-color: #333;
           color: white;
       }
       img{
           width: 80px;
           height: 80px;
           border-radius: 50%;
       }
</style>
</head>
<body>
<h2>Student Information Table</h2>
<?php
$students = array(
   array("Aaron","Images/Aaron.jpg", 18, "January 1, 2007", "09123456781"),
   array("Brian", "Images/Brian.jpg", 19, "February 2, 2006", "09123456782"),
   array("Charles", "Images/Charles.jpg", 20, "March 3, 2005", "09123456783"),
   array("Daniel", "Images/Daniel.jpg", 18, "April 4, 2007", "09123456784"),
   array("Ethan", "Images/Ethan.jpg", 21, "May 5, 2004", "09123456785"),
   array("Francis", "Images/Francis.jpg", 22, "June 6, 2003", "09123456786"),
   array("Gabriel", "Images/Gabriel.jpg", 20, "July 7, 2005", "09123456787"),
   array("Henry", "Images/Henry.jpg", 19, "August 8, 2006", "09123456788"),
   array("Ivan", "Images/Ivan.jpg", 18, "September 9, 2007", "09123456789"),
   array("Jacob", "Images/Jacob.jpg", 21, "October 10, 2004", "09123456780")
);
sort($students);
echo "<table>";
echo "<tr>";
echo "<th>No.</th>";
echo "<th>Name</th>";
echo "<th>Image</th>";
echo "<th>Age</th>";
echo "<th>Birthday</th>";
echo "<th>Contact Number</th>";
echo "</tr>";
for($i = 0; $i < count($students); $i++){
   echo "<tr>";
   echo "<td>".($i + 1)."</td>";
   echo "<td>".$students[$i][0]."</td>";
   echo "<td>
<img src='".$students[$i][1]."'>
</td>";
   echo "<td>".$students[$i][2]."</td>";
   echo "<td>".$students[$i][3]."</td>";
   echo "<td>".$students[$i][4]."</td>";
   echo "</tr>";
}
echo "</table>";
?>
</body>
</html>