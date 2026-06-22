<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "dogdb"
);

if(!$conn){
    die("Connection Failed: " . mysqli_connect_error());
}

?>