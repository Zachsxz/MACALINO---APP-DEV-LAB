<!DOCTYPE html>
<html>
<head>
    <title>My Fruits</title>

    <style>

        body{
            font-family: Arial;
        }

        table{
            width: 95%;
            margin: auto;
            border-collapse: collapse;
            text-align: center;
        }

        th, td{
            border: 1px solid black;
            padding: 15px;
        }

        img{
            width: 120px;
            height: 120px;
            object-fit: cover;
        }

        h2{
            text-align: center;
        }

    </style>

</head>
<body>

<?php

$fruits = array(

array("Apple","Red","Apple is rich in fiber and vitamins.","images/apple.jpg"),

array("Banana","Yellow","Banana gives energy and potassium.","images/banana.jpg"),

array("Cherry","Red","Cherry contains antioxidants.","images/cherry.jpg"),

array("Grapes","Purple","Grapes help heart health.","images/grapes.jpg"),

array("Lemon","Yellow","Lemon is rich in Vitamin C.","images/lemon.jpg"),

array("Mango","Orange","Mango is the national fruit of the Philippines.","images/mango.jpg"),

array("Orange","Orange","Orange improves immunity.","images/orange.jpg"),

array("Papaya","Orange","Papaya helps digestion.","images/papaya.jpg"),

array("Pineapple","Yellow","Pineapple contains bromelain enzyme.","images/pineapple.jpg"),

array("Watermelon","Green","Watermelon contains high water content.","images/watermelon.jpg")

);

?>

<h2>My Fruits</h2>

<table>

<tr>
    <th>Image</th>
    <th>Name</th>
    <th>Description</th>
    <th>Facts</th>
</tr>

<?php

foreach($fruits as $fruit){

echo "<tr>";

echo "<td><img src='".$fruit[3]."'></td>";

echo "<td>".$fruit[0]."</td>";

echo "<td>".$fruit[1]."</td>";

echo "<td>".$fruit[2]."</td>";

echo "</tr>";

}

?>

</table>

</body>
</html>