<?php
include("db.php");

if(isset($_POST['save']))
{
    $name = $_POST['name'];
    $breed = $_POST['breed'];
    $age = $_POST['age'];
    $address = $_POST['address'];
    $color = $_POST['color'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];

    $sql = "INSERT INTO dogs
    (name,breed,age,address,color,height,weight)
    VALUES
    ('$name','$breed','$age','$address','$color','$height','$weight')";

    mysqli_query($conn,$sql);

    echo "<script>alert('Dog Information Saved');</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Dog Register</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

<h2>Dog Information</h2>

<form method="POST">

<label>Name</label>
<input type="text" name="name" required>

<label>Breed</label>
<input type="text" name="breed" required>

<label>Age</label>
<input type="text" name="age" required>

<label>Address</label>
<input type="text" name="address" required>

<label>Color</label>
<input type="text" name="color" required>

<label>Height</label>
<input type="text" name="height" required>

<label>Weight</label>
<input type="text" name="weight" required>

<input type="submit" name="save" value="Save">

</form>

<p>© Crix Brix</p>

<a href="DogView.php">View Dogs</a>

</div>

</body>
</html>