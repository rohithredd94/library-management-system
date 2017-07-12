<?php
    session_start();
    if(!isset($_SESSION['username']) || !isset($_SESSION['name'])){
        header('Location: login.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Library Management System</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    
     <!-- Custom CSS -->
    <link href="styles.css" rel="stylesheet">

    <script src="js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Overpass" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Pangolin" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <style>
        .main-heading{
            text-align: left;
        }
    </style>
</head>
<body class="welcome-background">
    <div id="wrap">
    <div class="col-lg-12">
        <div class="col-lg-10">
            <h1 class="main-heading">Eugene McDermott Library</h1>
            <p>Hi, <?php echo $_SESSION['name']?>. You are logged in as <?php echo $_SESSION['username']?>.</p>
        </div>
        <div class="col-lg-2">
            <form method="post" action="reset.php">
                <input type="submit" class="btn btn-primary my-button" name="submit" value="Sign out"> 
            </form>
        </div>
    </div>
    <br><br><br><br>
    <div class="buttons-center-align">
        <a href="searchbooks.php" class="btn btn-primary custom-button">Search Books</a>
        <a href="bookloans.php" class="btn btn-primary custom-button">Book Loans</a>
        <a href="addborrower.php" class="btn btn-primary custom-button">Manage Borrowers</a>
        <a href="fines.php" class="btn btn-primary custom-button">Fines</a>
    </div>

    <div class="push"></div>
    </div>
    <footer>
        <p>Design and Development by Rohith Reddy K</p>
    </footer>
</body>
</html>