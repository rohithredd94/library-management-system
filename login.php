<?php
    session_start();
    if(isset($_SESSION['username']) && isset($_SESSION['name'])){
        header('Location: welcome.php');
        exit();
    }
?>

<!DOCTYPE html>
<html  lang="en" class="homepage-background">
<head>
    <meta charset="utf-8">
    <title>Library Management System</title>
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="validate.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="validate.css">
    <link rel="stylesheet" href="styles.css">

    <link href="https://fonts.googleapis.com/css?family=Overpass" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Pangolin" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link rel="icon" href="logo.png" type="image/png">
    <style>
        label{
            text-align: right;
        }
        span{
            text-align: left;
        }
    </style>
</head>
<body>
    <div id="wrap">
    <div class="col-lg-12">
        <div class="col-lg-offset-2 col-lg-8">
            <h1 class="main-heading">Eugene McDermott Library</h1><br><br>
            <p class="info1">Please log in to continue</p>
            <p class="info1" >All fields are required.</p>
            <p class="info1 error"><?php echo $_SESSION['error']; ?></p>
            <form method="post" action="validate.php" class="form-login">
                <label for="username" class="control-label col-lg-4">Username:</label>
                <input type="text" class="form-control input-ctrl" name="username" id="username"><br><br>

                <label for="password" class="control-label col-lg-4">Password:</label>
                <input type="password" class="form-control input-ctrl" name="password" id="password"><br><br>
                <input type="submit" name="submit" class="btn btn-primary my-button" value="Sign in"> 
            </form>
        </div>
    </div>
    <div class="push"></div>
    </div>
</body>
<footer>
    <p>Design and Development by Rohith Reddy K</p>
</footer>
</html>