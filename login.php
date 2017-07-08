<?php
    session_start();
    if(isset($_SESSION['username']) && isset($_SESSION['name'])){
        header('Location: welcome.php');
        exit();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Library Management System</title>
</head>
<body>
    <h2>Library</h2>
    <p>Please log in to continue</p>
    <p>All fields are required.</p>
    <form method="post" action="validate.php">
        Username: <input type="text" name="username" id="username"><br><br>

        Password: <input type="password" name="password" id="password"><br><br>

        <input type="submit" name="submit" value="Sign in"> 
    </form>
    <p><?php echo $_SESSION['error']; ?></p>
</body>
</html>