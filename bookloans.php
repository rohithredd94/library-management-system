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
        form{
            padding-top: 100px;
        }
        input{
            width: 100%;
            max-width: 100%;
            font-weight: bold;
        }
        .new-button-small{
            font-size: 16px;
        }
        .new-button-small:hover{
            background-color: red;
        }
        .new-button:hover{
            background-color: green;
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
            <p>Hi, <?php echo $_SESSION['name']?>.<br>You are logged in as <?php echo $_SESSION['username']?>.</p>
        </div>
        <div class="col-lg-8">
            <h1 class="main-heading">Book Loans</h1>
        </div>
        <div class="col-lg-2">
            <p>Today's date is <?php echo date('Y-m-d');?></p>
        </div>
    </div>
    <br><br>
<?php
    session_start();
    if($_SERVER["REQUEST_METHOD"] == "GET"){
    //if(isset($_GET['isbn'])){
        if(isset($_GET['isbn']))
            $isbn = $_GET['isbn'];
        else
            $isbn = '';
?>      
        <div class="col-lg-12">
        <div class="col-lg-offset-2 col-lg-8">
        <form class="form-horizontal" action="bookloans.php" method="get">
            <div class="form-group">
                <label for="cardNo" class="control-label col-xs-2">Borrower ID</label>
                <div class="col-xs-10">
                    <input type="text" id="cardNo" class="form-control" name="cardNo" placeholder="Enter Card No.." value="<?php echo $_GET['cardNo']?>">
                </div>
            </div>
            <div class="form-group">
                <label for="isbn" class="control-label col-xs-2">ISBN</label>
                <div class="col-xs-10">
                    <input type="text" id="isbn" class="form-control" name="isbn" placeholder="Enter Book ISBN.." value="<?php echo $_GET['isbn']?>">
                    <button type="submit" class="btn btn-primary new-button-small">Check</button>
<?php
        if($isbn != ''){
            include('mysql_connect.php');
            //echo var_dump($con)."<br>";
            //$query = "SELECT * FROM book where isbn like '%".$isbn."%';";
            $query = "SELECT * FROM book where isbn = '$isbn';";
            //echo $query;
            $result = mysqli_query($con, $query);
            //echo var_dump($result);
            if($result->num_rows == 0){
                echo "Invalid ISBN Number";
            }else{
                //echo $result->num_rows;
                $query1 = "SELECT * FROM book_loans where isbn = '$isbn' and date_in IS NULL;";
                $result1 = mysqli_query($con,$query1);
                if($result1->num_rows > 0){
                    $available = 'Not Available';
                }else{
                    $available = 'Available';
                }
                echo $available;
            }
        }
        mysqli_close($con);
    }
?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-offset-2 col-xs-10">
                    <a class="btn btn-primary new-button" onclick="checkin()">Checkin</a>
                    <a class="btn btn-primary new-button" onclick="checkout()">Checkout</a>
                </div>
            </div>
        </form>
        </div>
        </div>
        <div class="push"></div>
        </div>
    <script>
    function checkin()
    {
        var a=document.getElementById("isbn");
        var isbn=a.value;
     
        a=document.getElementById("cardNo");
        var cardNo=a.value;
     
        window.location='checkin.php?cardNo=' + cardNo + '&isbn=' + isbn;
    }
 
    function checkout()
    {
        var a=document.getElementById("isbn");
        var isbn=a.value;
     
        a=document.getElementById("cardNo");
        var cardNo=a.value;
     
        window.location='checkout.php?cardNo=' + cardNo + '&isbn=' + isbn;
    }
    </script>
    <footer>
        <p>Design and Development by Rohith Reddy K</p>
    </footer>
</body>
</html>