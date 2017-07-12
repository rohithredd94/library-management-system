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
    <title>Fines</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    
     <!-- CSS -control-->
    <link href="styles.css" rel="stylesheet">
    <script src="js/jquery-3.2.1.min.js"></script>
    <!--<script src="js/bootstrap.min.js"></script>-->
    <script src="js/check.js"></script>
    <link rel="stylesheet" href="css/validate.css">
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css?family=Overpass" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Pangolin" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link rel="icon" href="logo.png" type="image/png">
    <style>
        div.col-xs-10,div.col-xs-4{
            padding-top: 5px;
        }
        input{
            width: 100%;
            max-width: 100%;
            font-weight: bold;
        }
        #update{
            bottom:1%; position:absolute; margin-left: 50px;
        }
        div.col-xs-offset-2{
            padding-left: 5px;
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
                    <li><a href="bookloans.php">Book Loans</a></li>
                    <li><a href="addborrower.php">Manage Borrowers</a></li>
                    <li class="active"><a href="fines.php">Fines</a></li>
                    <li><a href="reset.php">Log out</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <br>
    <div id="wrap">
    <div class="col-lg-12">
        <div class="col-lg-2">
            <p>Hi, <?php echo $_SESSION['name']?>.<br>You are logged in as <?php echo $_SESSION['username']?>.</p>
        </div>
        <div class="col-lg-8">
            <h1 class="main-heading">Fines</h1><br>
        </div>
        <div class="col-lg-2">
            <p>Today's date is <?php echo date('Y-m-d');?></p><br><br>
            <a id="update" href="updatefines.php" class="btn btn-default btn-xs new-button">Update Fines</a>
        </div>
    </div>
<?php
    if(isset($_GET['cardNo']))
        $cardNo = $_GET['cardNo'];
    else
        $cardNo = '';
?>
    <div class="col-lg-12">
    <div class="col-lg-offset-2 col-lg-8">
    <form class="form-horizontal" action="fines.php" method="get">
        <p class="info1">Please enter the Card ID</p>
        <div class="form-group">
            <label for="cardNo" class="control-label col-xs-2">Borrower ID</label>
            <div class="col-xs-10">
                <input type="text" id="cardNo" class="form-control" name="cardNo" placeholder="Enter Card No....." value="<?php echo $cardNo?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-offset-2  col-xs-2">
                <button type="submit" class="btn btn-primary new-button">Search</button>
            </div>
        </div>
    </form>
    </div>
    </div>

<?php
    if($cardNo != '' && !isset($_GET['pay'])){
        $cardNo = $_GET['cardNo'];
        include('mysql_connect.php');

        $query = "SELECT SUM(fines.fine_amt) as fine FROM fines, book_loans where fines.loan_id = book_loans.loan_id and fines.paid='0' and book_loans.card_id = '$cardNo';";
        //echo $query;

        $result = mysqli_query($con, $query);
        $resultarr = mysqli_fetch_array($result);

        if($resultarr['fine'] != NULL) {

?>
            <br><p class="info1">You have an outstanding due of $<?php echo $resultarr['fine'];?> <a href="fines.php?cardNo=<?php echo $cardNo;?>&pay=1" class="btn btn-primary new-button-small">Pay Fine</a></p>
            
<?php
        }else{
?>  
            <p class="info1">No fines for this user.</p>
<?php
        }

        mysqli_close($con);
    }
    if($cardNo != '' && isset($_GET['pay'])){
        $cardNo = $_GET['cardNo'];
        include('mysql_connect.php');
        $query1 = "SELECT * FROM fines, book_loans WHERE fines.loan_id = book_loans.loan_id and book_loans.card_id = '".$cardNo."' and paid = '0';";
        $query = "SELECT COUNT(*) FROM book_loans where card_id = '".$cardNo."' AND due_date < '".date("Y-m-d")."' AND date_in IS NULL;"; //Check if books have been returned
        //echo $query1;
        $result2 = mysqli_query($con, $query1);
        //$resultarr2 = mysqli_fetch_array($result2);
?>
        <table class="table table-center-align">
        
            <thead>
                <tr>
                    <th>Loan ID</th>
                    <th>Card No.</th>
                    <th>ISBN</th>
                    <th>Fine Amount</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
<?php
        //edit starts here
        while($resultarr2 = mysqli_fetch_array($result2)){
?>
                <tr>
                    <td><?php echo $resultarr2['loan_id']; ?></td>
                    <td><?php echo $resultarr2['card_id']; ?></td>
                    <td><?php echo $resultarr2['isbn']; ?></td>
                    <td><?php echo $resultarr2['fine_amt']; ?></td>
                
<?php
            if($resultarr2['date_in'] == NULL){
?>
                    <td>Book is still out</td>
                </tr>
<?php
            }else{
?>
                    <td><button type="button" id=" <?php echo $resultarr2['loan_id']?> " class="btn btn-primary new-button-small" data-loanid="<?php echo $resultarr2['loan_id']; ?>" onClick="pay_fine(this.id)">Pay Fine</button></td>
                </tr>
<?php
            }
        }
        mysqli_close($con);
    }
    if(isset($_GET['loanid'])){
        include('mysql_connect.php');
        $query = "SELECT * FROM fines where loan_id = '".$_GET['loanid']."';";
        //echo $query;
        $result = mysqli_query($con, $query);
        if($result->num_rows == 1){
            $query = "UPDATE fines SET paid = '1' where loan_id = '".$_GET['loanid']."';";
            //echo $query;
            $result1 = mysqli_query($con, $query);
            if($result1){
?>
                <p class="info1">Fine Paid for this book <a type="button" class="btn btn-primary new-button-small" href="fines.php">Done</a></p>
                
<?php
            }else{
?>
                <p class="info1">Couldn't pay the fine</p>
<?php
            }
        }else{
            echo "Something is wrong";
        }
        mysqli_close($con);
    }
           
?>
</tbody>
</table>
<div class="push"></div>
</div>
<script>
    
function pay_fine(buttonID){
    var button = document.getElementById(buttonID);
    var loanID = button.getAttribute("data-loanid");
    window.location.href = "fines.php?loanid=" + loanID;
    
}
</script>
    <footer>
        <p>Design and Development by Rohith Reddy K</p>
    </footer>
</body>
</html>