<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$name = "Mathew Zachary L. Macalino";
$email = "mzmacalino@gmail.com";
$phone = "+63-912-345678";
$location = "Manila, Philippines";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Resume</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="header">
<h1><?php echo $name; ?></h1>
<p><?php echo $email; ?> | <?php echo $phone; ?> | <?php echo $location; ?></p>
</div>
<div class="container">
<!-- LEFT -->
<div class="left">
<div class="section-title">Profile</div>
<div class="card">
<p>
               IT student focused on web development and software engineering.
               Builds responsive websites and develops systems using PHP, JavaScript, and C++.
</p>
</div>
<div class="section-title">Experience</div>
<div class="card">
<h3>Junior Developer</h3>
<p>Led projects and junior developers.</p>
</div>
<div class="card">
<h3>Developer</h3>
<p>Built and maintained web applications.</p>
</div>
<div class="section-title">Projects</div>
<div class="card">
<h3>Portfolio Website</h3>
<p>Built a responsive portfolio using HTML, CSS, and PHP.</p>
</div>
<div class="card">
<h3>Python Dashboard</h3>
<p>Created a GUI dashboard using CustomTkinter.</p>
</div>
<div class="card">
<h3>Data Structures System</h3>
<p>Implemented linked lists, stacks, and queues in C++.</p>
</div>
</div>
<!-- RIGHT -->
<div class="right">
<div class="section-title">Skills</div>
<div class="card">
<p><b>Languages:</b> PHP, JavaScript, HTML, CSS, Python, C++</p>
<p><b>Tools:</b> Git, MySQL, VS Code</p>
</div>
<div class="section-title">Education</div>
<div class="card">
<h3>BS Information Technology</h3>
<small>FEU Institute of Technology | 2024 - Present</small>
<p>Relevant coursework: Programming, Data Structures, Web Development</p>
</div>
<div class="section-title">Certifications</div>
<div class="card">
<p>PHP Developer Certification</p>
<p>Python Developer Certification</p>
<p>Database Developer Certification</p>
<p>CSS Developer Certification</p>
</div>
<div class="section-title">Achievements</div>
<div class="card">
<p>Completed multiple programming projects with high evaluation</p>
<p>Strong performance in IT-related subjects</p>
</div>
</div>
</div>
</body>
</html>