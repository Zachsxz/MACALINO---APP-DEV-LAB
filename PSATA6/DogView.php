<?php
include("db.php");

$sql = "SELECT * FROM dogs";
$result = mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Dog View</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="view-container">

<?php
$count = 1;

while($row = mysqli_fetch_assoc($result))
{
?>

<div class="card">

<h3>Dog <?php echo $count; ?></h3>

<p>Name: <?php echo $row['name']; ?></p>
<p>Breed: <?php echo $row['breed']; ?></p>
<p>Age: <?php echo $row['age']; ?></p>
<p>Address: <?php echo $row['address']; ?></p>
<p>Color: <?php echo $row['color']; ?></p>
<p>Height: <?php echo $row['height']; ?></p>
<p>Weight: <?php echo $row['weight']; ?></p>

</div>

<?php
$count++;
}
?>

</div>

</body>
</html>