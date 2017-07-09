<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Book Loans</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    
     <!-- Custom CSS -->
    <link href="css/styles.css" rel="stylesheet">
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

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


    <br>
    <h1 style="color:#090; font-family:sans-serif; font-weight:700; font-size:55px; text-align:center">BOOK LOANS</h1><br><br>
<?php
    session_start();
    if($_SERVER["REQUEST_METHOD"] == "GET"){
    //if(isset($_GET['isbn'])){
        if(isset($_GET['isbn']))
            $isbn = $_GET['isbn'];
        else
            $isbn = '';
?>
        <form class="form-horizontal" action="bookloans.php" method="get">
            <div class="form-group">
                <label for="cardNo" class="control-label col-xs-2" style="color:#CCC; font-weight:bold; font-size:20px">Borrower Card ID</label>
                <div class="col-xs-10">
                    <input type="text" id="cardNo" class="form-control" name="cardNo" placeholder="Enter Card No.." value="<?php echo $_GET['cardNo']?>" style="max-width:1000px; font-weight:bold" >
                </div>
            </div>
            <div class="form-group">
                <label for="isbn" class="control-label col-xs-2" style="color:#CCC; font-weight:bold; font-size:20px">ISBN</label>
                <div class="col-xs-10">
                    <input type="text" id="isbn" class="form-control" name="isbn" placeholder="Enter Book ISBN.." value="<?php echo $_GET['isbn']?>" style="max-width:1000px; font-weight:bold">
                    <button type="submit" class="btn btn-primary" style="background:#F00; font-weight:bold">Check</button>
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
                    <a class="btn btn-primary" style="color:#FFF; background:#090" onclick="checkin()">Checkin</a>
                    <a class="btn btn-primary" style="color:#FFF; background:#090" onclick="checkout()">Checkout</a>
                </div>
            </div>
        </form>
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
</body>