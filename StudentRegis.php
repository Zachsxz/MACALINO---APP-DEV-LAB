<!DOCTYPE html>
<html>
<head>
<title>Student Registration Form</title>
<style>
       body{
           font-family: Arial;
           background-color: #f2f2f2;
       }
       .container{
           width: 900px;
           margin: auto;
           background-color: white;
           padding: 20px;
           border: 2px solid black;
       }
       h1{
           text-align: center;
       }
       .section{
           background-color: black;
           color: white;
           padding: 5px;
           margin-top: 15px;
       }
       .line{
           border-bottom: 1px solid black;
           margin-top: 10px;
           margin-bottom: 10px;
       }
       p{
           font-size: 15px;
       }
       table{
           width: 100%;
       }
       td{
           padding: 5px;
       }
</style>
</head>
<body>
<div class="container">
<h1>Student Registration Form</h1>
<?php
       $fullname = "Mathew Zachary Macalino";
       $studentnumber = "2025-12345";
       $course = "BS Information Technology";
       $school = "FEU Institute of Technology";
       $gender = "Male";
       $birthdate = "January 1, 2005";
       $address = "Quezon City";
       $citizenship = "Filipino";
       $skill1 = "HTML";
       $skill2 = "CSS";
       $skill3 = "PHP";
       $skill4 = "C++";
   ?>
<div class="section">
       Student Information
</div>
<table>
<tr>
<td>Full Name:</td>
<td><?php echo strtoupper($fullname); ?></td>
</tr>
<tr>
<td>Student Number:</td>
<td><?php echo $studentnumber; ?></td>
</tr>
<tr>
<td>Course:</td>
<td><?php echo strtoupper($course); ?></td>
</tr>
<tr>
<td>Gender:</td>
<td><?php echo $gender; ?></td>
</tr>
<tr>
<td>Birth Date:</td>
<td><?php echo $birthdate; ?></td>
</tr>
</table>
<div class="section">
       School Information
</div>
<table>
<tr>
<td>School:</td>
<td><?php echo strtoupper($school); ?></td>
</tr>
<tr>
<td>Address:</td>
<td><?php echo strtoupper($address); ?></td>
</tr>
</table>
<div class="section">
       Background
</div>
<p>
       I am a student interested in programming and web development.
       I enjoy creating websites and systems using PHP and HTML.
</p>
<div class="section">
       Skills
</div>
<ul>