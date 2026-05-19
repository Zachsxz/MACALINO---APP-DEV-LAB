<!DOCTYPE html>
<html>
<head>

    <title>Student Resume</title>

    <style>

        body{
            font-family: Arial;
        }

        .container{
            width: 70%;
            margin: auto;
            border: 2px solid black;
        }

        .top{
            display: flex;
        }

        .image{
            width: 30%;
            border-right: 1px solid black;
            text-align: center;
            padding: 20px;
        }

        .image img{
            width: 150px;
            height: 150px;
        }

        .info{
            width: 70%;
            text-align: center;
            padding-top: 80px;
        }

        .menu{
            border-top: 1px solid black;
            text-align: center;
            padding: 10px;
        }

        a{
            text-decoration: none;
            color: black;
            font-size: 20px;
        }

    </style>

</head>

<body>

<div class="container">

    <div class="top">

        <div class="image">
            <img src="images/profile.jpg">
        </div>

        <div class="info">
            <h2>Mathew Zachary L. Macalino</h2>
            <p>BS Information Technology Student</p>
        </div>

    </div>

    <div class="menu">
        <a href="career.php">• Career Objective</a>
    </div>

    <div class="menu">
        <a href="personal.php">• Personal Information</a>
    </div>

    <div class="menu">
        <a href="education.php">• Educational Attainment</a>
    </div>

    <div class="menu">
        <a href="skills.php">• Skills Page</a>
    </div>

    <div class="menu">
        <a href="affiliation.php">• Affiliation Page</a>
    </div>

    <div class="menu">
        <a href="experience.php">• Work Experience Page</a>
    </div>

</div>

</body>
</html>