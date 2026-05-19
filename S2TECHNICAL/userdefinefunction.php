<!DOCTYPE html>
<html>
<head>
    <title>Volume of Shapes</title>
    <style>
        body{
            font-family: Arial;
        }

        table{
            width: 80%;
            margin: auto;
            border-collapse: collapse;
            text-align: center;
        }

        th, td{
            border: 1px solid black;
            padding: 10px;
        }

        h2{
            text-align: center;
        }
    </style>
</head>
<body>

<?php

function cube($s){
    return pow($s,3);
}

function rectangularPrism($l,$w,$h){
    return $l * $w * $h;
}

function cylinder($r,$h){
    return pi() * pow($r,2) * $h;
}

function cone($r,$h){
    return (1/3) * pi() * pow($r,2) * $h;
}

function sphere($r){
    return (4/3) * pi() * pow($r,3);
}

?>

<h2>Volume of Shapes</h2>

<table>
    <tr>
        <th>Shape</th>
        <th>Values</th>
        <th>Formula</th>
        <th>Answer</th>
    </tr>

    <tr>
        <td>Cube</td>
        <td>s = 5</td>
        <td>V = s³</td>
        <td><?php echo cube(5); ?></td>
    </tr>

    <tr>
        <td>Rectangular Prism</td>
        <td>l = 4, w = 3, h = 2</td>
        <td>V = lwh</td>
        <td><?php echo rectangularPrism(4,3,2); ?></td>
    </tr>

    <tr>
        <td>Cylinder</td>
        <td>r = 3, h = 5</td>
        <td>V = πr²h</td>
        <td><?php echo number_format(cylinder(3,5),2); ?></td>
    </tr>

    <tr>
        <td>Cone</td>
        <td>r = 3, h = 5</td>
        <td>V = 1/3 πr²h</td>
        <td><?php echo number_format(cone(3,5),2); ?></td>
    </tr>

    <tr>
        <td>Sphere</td>
        <td>r = 4</td>
        <td>V = 4/3 πr³</td>
        <td><?php echo number_format(sphere(4),2); ?></td>
    </tr>

</table>

</body>
</html>
