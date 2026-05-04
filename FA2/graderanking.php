<?php
$rank = "";
$grade = "";
$name = "";
if (isset($_POST['submit'])) {
   $name = $_POST['name'];
   $grade = $_POST['grade'];
   if ($grade >= 93 && $grade <= 100) $rank = "A";
   elseif ($grade >= 90) $rank = "A-";
   elseif ($grade >= 87) $rank = "B+";
   elseif ($grade >= 83) $rank = "B";
   elseif ($grade >= 80) $rank = "B-";
   elseif ($grade >= 77) $rank = "C+";
   elseif ($grade >= 73) $rank = "C";
   elseif ($grade >= 70) $rank = "C-";
   elseif ($grade >= 67) $rank = "D+";
   elseif ($grade >= 63) $rank = "D";
   elseif ($grade >= 60) $rank = "D-";
   else $rank = "F";
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Grade Ranking</title>
<link rel="stylesheet" href="graderanking.css">
</head>
<body>
<div class="container">
<h2>Grade Ranking System</h2>
<form method="post">
<input type="text" name="name" placeholder="Enter Name" required>
<input type="number" name="grade" placeholder="Enter Grade" required>
<button type="submit" name="submit">Submit</button>
</form>
<?php if ($rank != ""): ?>
<div class="result">
<div class="name">Name: <?php echo $name; ?></div>
<div class="boxes">
<div class="box">
<p>Rank</p>
<h3><?php echo $rank; ?></h3>
</div>
<div class="box">
<p>Grade</p>
<h3><?php echo $grade; ?></h3>
</div>
<div class="box picture">
               Picture
</div>
</div>
</div>
<?php endif; ?>
</div>
</body>
</html>