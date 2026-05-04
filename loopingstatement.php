<!DOCTYPE html>
<html>
<head>
<title>Two-Digit Combinations</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<h2>Two-Digit Combinations</h2>
<p>
<?php
       for ($i = 0; $i <= 99; $i++) {
           // format to always show 2 digits (00, 01, 02...)
           $num = str_pad($i, 2, "0", STR_PAD_LEFT);
           echo $num;
           if ($i < 99) {
               echo ", ";
           }
       }
       ?>
</p>
</div>
</body>
</html>