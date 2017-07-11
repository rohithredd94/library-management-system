<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Add Borrower</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    
     <!-- CSS -control-->
    <link href="css/styles.css" rel="stylesheet">
    <script src="js/jquery-3.2.1.min.js"></script>
    <!--<script src="js/bootstrap.min.js"></script>-->
    <script src="js/check.js"></script>
    <link rel="stylesheet" href="css/validate.css">
    <link rel="stylesheet" href="css/styles.css">
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
    <div class="col-lg-12">
        <div class="col-lg-3">
            
        </div>
        <div class="col-lg-6">
            <h1 style="color:#090; font-family:sans-serif; font-weight:700; font-size:55px; text-align:center">Fines</h1><br><br>
        </div>
        <div class="col-lg-1">
            
        </div>
        <div class="col-lg-2">
            <br><br><br>
            <a id="reset" href="updatefines.php" class="btn btn-default btn-xs custom-button" style="background:#000; bottom:1%; position:absolute;color:#FFF; font-weight:bold; margin: auto; margin-left: 100px;">Update Fines</a>
        </div>
    </div>
<?php
    if(isset($_GET['cardNo']))
        $cardNo = $_GET['cardNo'];
    else
        $cardNo = '';
?>
    <form class="form-horizontal" action="fines.php" method="get">
        <p style="color:#000; font-size:18px; font-weight:bold; text-align:left; margin-left:5%; font-style:italic">Enter the card No.</p>
        <div class="form-group">
            <label for="cardNo" class="control-label col-xs-3" style="color:#CCC; font-weight:bold; font-size:20px">Card No.</label>
            <div class="col-xs-9">
                <input type="text" id="cardNo" class="form-control" name="cardNo" placeholder="Enter Card No....." style="max-width:1000px; font-weight:bold" value="<?php echo $cardNo?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-offset-3  col-xs-2" style="margin-right: 20px; padding-left: 5px;">
                <button type="submit" class="btn btn-primary custom-button" style="color:#FFF; background:#000; font-weight: bold; margin: 2px solid #000;">Search</button>
            </div>
        </div>
    </form>

<?php
    if(isset($_GET['cardNo']) && !isset($_GET['pay'])){
        $cardNo = $_GET['cardNo'];
        include('mysql_connect.php');

        $query = "SELECT SUM(fines.fine_amt) as fine FROM fines, book_loans where fines.loan_id = book_loans.loan_id and fines.paid='0' and book_loans.card_id = '$cardNo';";
        //echo $query;

        $result = mysqli_query($con, $query);
        $resultarr = mysqli_fetch_array($result);

        if($resultarr['fine'] != NULL) {

?>
            <br><p style="color:#000; font-size:18px; font-weight:bold; text-align:left; margin-left:5%; font-style:italic">You have an outstanding due of $<?php echo $resultarr['fine'];?></p>
            <a href="fines.php?cardNo=<?php echo $cardNo;?>&pay=1" class="btn btn-primary" style="color:#000; background:#FFF; margin-left:5%">Pay Fine</a>
<?php
        }else{
?>  
            <p style="color:#000; font-size:18px; font-weight:bold; text-align:left; margin-left:5%; font-style:italic">No fines for this user.</p>
<?php
        }

        mysqli_close($con);
    }
    if(isset($_GET['cardNo']) && isset($_GET['pay'])){
        $cardNo = $_GET['cardNo'];
        include('mysql_connect.php');
        $query1 = "SELECT * FROM fines, book_loans WHERE fines.loan_id = book_loans.loan_id and book_loans.card_id = '".$cardNo."' and paid = '0';";
        $query = "SELECT COUNT(*) FROM book_loans where card_id = '".$cardNo."' AND due_date < '".date("Y-m-d")."' AND date_in IS NULL;"; //Check if books have been returned
        echo $query1;
        $result2 = mysqli_query($con, $query1);
        //$resultarr2 = mysqli_fetch_array($result2);
?>
        <table class="table table-center-align" style="color:#000; background:#999; max-width:1200px;">
        
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
                    <td><button type="button" id=" <?php echo $resultarr2['loan_id']?> " class="btn btn-primary" style="background:#090;" data-loanid="<?php echo $resultarr2['loan_id']; ?>" onClick="pay_fine(this.id)">Pay Fine</button></td>
                </tr>
<?php
            }
        }
        mysqli_close($con);
    }
    if(isset($_GET['loanid'])){
        include('mysql_connect.php');
        $query = "SELECT * FROM fines where loan_id = '".$_GET['loanid']."';";
        echo $query;
        $result = mysqli_query($con, $query);
        if($result->num_rows == 1){
            $query = "UPDATE fines SET paid = '1' where loan_id = '".$_GET['loanid']."';";
            echo $query;
            $result1 = mysqli_query($con, $query);
            if($result1){
?>
                <p style="color:#000; font-size:18px; font-weight:bold; text-align:left; margin-left:5%; font-style:italic">Fine Paid for this book</p>
                <a type="button" class="btn" style="background:#090; color:#FFF; font-weight:bold" href="fines.php">Done</a>
<?php
            }else{
?>
                <p style="color:#000; font-size:18px; font-weight:bold; text-align:left; margin-left:5%; font-style:italic">Couldn't pay the fine</p>
<?php
            }
        }else{
            echo "Something is wrong";
        }
        mysqli_close($con);
    }
           
?> 
<script>
    
function pay_fine(buttonID){
    var button = document.getElementById(buttonID);
    var loanID = button.getAttribute("data-loanid");
    window.location.href = "fines.php?loanid=" + loanID;
    
}
</script>
</body>
</html>