<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Library Management System</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    
     <!-- Custom CSS -->
    <link href="css/styles.css" rel="stylesheet">

    <script src="js/bootstrap.min.js"></script>
</head>
<body>

    <h1 class="text-center-align" style="font-weight:bold; font-size:55px">Eugene McDermott Library</h1>

    <div class="buttons-center-align">
        <a href="searchbooks.php" class="btn btn-primary custom-button">Search Books</a>
        <a href="bookloans.php" class="btn btn-primary custom-button">Book Loans</a>
        <a href="addborrower.php" class="btn btn-primary custom-button">Manage Borrowers</a>
        <a href="fines.php" class="btn btn-primary custom-button">Fines</a>
    </div>

    <!--<footer>
        <form method="post" action="reset.php">

            <input type="submit" name="submit" value="Sign out"> 
        </form>
    </footer>-->

    <footer>
        <a id="reset" href="reset.php" class="btn btn-default btn-xs custom-button" style="bottom:1%; position:absolute; font-weight:bold">Log out</a>
    </footer>
</body>
</html>