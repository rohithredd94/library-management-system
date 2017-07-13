<?php
    session_start();
    if(!isset($_SESSION['username']) || !isset($_SESSION['name'])){
        header('Location: login.php');
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Book Loans</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    
     <!-- Custom CSS -->
    <link href="styles.css" rel="stylesheet">
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Overpass" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Pangolin" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link rel="icon" href="logo.png" type="image/png">
    <style>
        div.col-xs-10,div.col-xs-4{
            padding-top: 5px;
        }
        p.info1{
            color: green;
        }
        input{
            width: 100%;
            max-width: 100%;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <nav role="navigation" class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
           <div class="navbar-header">
                <a href="welcome.php" class="navbar-brand">Eugene McDermott Library</a>
            </div>
            <div id="navbarCollapse" class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="searchbooks.php">Search Books</a></li>
                    <li class="active"><a href="bookloans.php">Book Loans</a></li>
                    <li><a href="addborrower.php">Manage Borrowers</a></li>
                    <li><a href="fines.php">Fines</a></li>
                    <li><a href="reset.php">Log out</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="wrap">
    <div class="col-lg-12">
        <div class="col-lg-2">
            <br>
            <p>Hi, <?php echo $_SESSION['name']?>.<br>You are logged in as <?php echo $_SESSION['username']?>.</p>
        </div>
        <div class="col-lg-8">
            <br>
            <h1 class="main-heading">Check Out</h1>
        </div>
        <div class="col-lg-2">
            <br>
            <p>Today's date is <?php echo date('Y-m-d');?></p>
        </div>
    </div>
    <br><br>

<?php
    if(isset($_GET['isbn']) && !isset($_GET['cardNo'])){
        $isbn = $_GET['isbn'];
?>
    <div class="col-lg-12">
    <div class="col-lg-offset-2 col-lg-8">
    <form class="form-horizontal" action="checkout.php" method="get">
    <p class="info1">Please enter your Card ID to checkout this book</p> 
        <div class="form-group">
            <label for="cardNo" class="control-label col-xs-2">Borrower ID</label>
            <div class="col-xs-10">
                <input type="text" id="cardNo" class="form-control" name="cardNo" placeholder="Enter Borrower ID....">
            </div>
        </div>
        <div class="form-group">
            <label for="isbn" class="control-label col-xs-2">Book ID</label>
            <div class="col-xs-10">
                <input type="text" id="isbn" class="form-control" name="isbn" placeholder="Enter ISBN....." value="<?php echo $isbn?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-offset-2 col-xs-10">
                <button type="submit" class="btn btn-primary new-button">Confirm</button>
            </div>
        </div>
    </form>
    </div>
    </div>

<?php
    }
    elseif(isset($_GET['isbn']) && isset($_GET['cardNo'])){
        $isbn = $_GET['isbn'];
        $cardNo = $_GET['cardNo'];
?>
    <div class="col-lg-12">
    <div class="col-lg-offset-2 col-lg-8">
    <form class="form-horizontal" action="checkout.php" method="get">
       <div class="form-group">
            <label for="cardNo" class="control-label col-xs-2">Borrower ID</label>
            <div class="col-xs-10">
                <input type="text" id="cardNo" class="form-control" name="cardNo" placeholder="Enter Borrower ID...." value="<?php echo $cardNo?>">
            </div>
                    <?php   
                        //check if Borrower ID is valid
                        include('mysql_connect.php');
                        $query= "SELECT * from borrowers WHERE card_id = '$cardNo';";
                        $result1= mysqli_query($con,$query);
                        if ($result1->num_rows == 0) { 
                            ?>
                                <p style="font-weight:bold; color:#F00">&nbsp; &nbsp; &nbsp; &nbsp; Error: Incorrect Card ID</p>
                            <?php   
                        }
                        mysqli_close($con);
                    
                    ?>
        </div>
        <div class="form-group">
            <label for="isbn" class="control-label col-xs-2">Book ID</label>
            <div class="col-xs-10">
                <input type="text" id="isbn" class="form-control" name="isbn" placeholder="Enter Book ID....." value="<?php echo $isbn?>">
            </div>
                    <?php   
                        //check if Book ID is valid
                        include('mysql_connect.php');
                        $query = "SELECT * FROM book where isbn = '$isbn';";
                        $result2= mysqli_query($con,$query);
                        if ($result2->num_rows == 0) { 
                            ?>
                                <p style="font-weight:bold; color:#F00">&nbsp; &nbsp; &nbsp; &nbsp; Error: Incorrect ISBN Number</p>
                            <?php   
                        }
                        mysqli_close($con);
                    ?>
        </div>
    <?php
        if($result1->num_rows == 0 || $result2->num_rows == 0){
    ?>
            <div class="form-group">
                <div class="col-xs-offset-2 col-xs-10">
                    <button type="submit" class="btn btn-primary new-button">Check Out</button>
                </div>
            </div>
    <?php
        }else{//Card id and book id are valid
            include('mysql_connect.php');
            //Checking if book is available
            $query = "SELECT * FROM book_loans where isbn = '$isbn' and date_in IS NULL;";
            $result3 = mysqli_query($con,$query);
            //echo var_dump($result3);
            if($result3->num_rows > 0){//Is the book available
                $available = 'Not Available';
            ?>
                
                <div class="form-group">
                    <div class="col-xs-offset-2 col-xs-10">
                        <p class="info1">Book is not Available for Checkout. Check again later</p>
                        <a href="bookloans.php" class="btn btn-primary new-button">Check Out another book</a></li>
                    </div>
                </div>
            <?php
            }else{//Book is available
                $available = 'Available';
                //Checking if checkout limit has reached
                $query = "SELECT * FROM book_loans where card_id = '$cardNo' and date_in IS NULL;";
                $result4 = mysqli_query($con, $query);
                //echo var_dump($result4);
                if($result4->num_rows == 3){//Check out limit???
            ?>
                    <div class="form-group">
                        <div class="col-xs-offset-2 col-xs-10">
                            <p class="info1">Check out limit reached. Can't checkout any more books</p>
                            <a href="bookloans.php" class="btn btn-primary new-button">Check Out another book</a></li>
                        </div>
                    </div>
            <?php
                }else{//User can now checkout books
                    //$query = "INSERT INTO book_loans (isbn, card_id, date_out, due_date, date_in) VALUES ('$isbn', $cardNo, '".date("Y-m-d")."', '".date('Y-m-d', strtotime("+14 days"))."');"
                    $query = "INSERT INTO book_loans (isbn, card_id, date_out, due_date) VALUES ('$isbn', '$cardNo', '".date("Y-m-d")."', '".date("Y-m-d", strtotime("+14 days"))."');";
                    //echo "<br>".$query."<br>";
                    $result5 = mysqli_query($con, $query);
                    //echo var_dump($result5); //Checkout final
            ?>
                <div class="form-group">
                    <div class="col-xs-offset-2 col-xs-10">
                        <p class="info1">Book checked out successfully. Book is due by <?php echo date("Y-m-d", strtotime("+14days"));?></p>
                        <a href="bookloans.php" class="btn btn-primary new-button">Check Out another book</a></li>
                    </div>
                </div>
            <?php
                }

            }
            //echo $available;
            mysqli_close($con);
        }
    ?>
    </form>
    </div>
    </div>
<?php
    }
?>
    <div class="push"></div>
    </div>
    <footer>
        <p>Design and Development by Rohith Reddy K</p>
    </footer>
</body>

</html>

