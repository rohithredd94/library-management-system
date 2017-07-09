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
    <h1 style="color:#090; font-family:sans-serif; font-weight:700; font-size:55px; text-align:center">CHECKIN</h1><br><br>

<?php
    if(isset($_GET['isbn']))
        $isbn = $_GET['isbn'];
    else
        $isbn = '';
    if(isset($_GET['cardNo']))
        $cardNo = $_GET['cardNo'];
    else
        $isbn = '';
    if(isset($_GET['bname']))
        $bname = $_GET['bname'];
    else
        $bname = '';

    if(isset($_GET['loanid'])){
        $loanid = $_GET['loanid'];
    }
    else
        $loanid = '';

    //if(!isset($_GET['loanid'])) {
    if($loanid == '') {
        echo "Hello";
?>
        <form class="form-horizontal" action="checkin.php" method="get">
            <div class="form-group">
                <label for="cardNo" class="control-label col-xs-2" style="color:#CCC; font-weight:bold; font-size:20px">Card No.</label>
                <div class="col-xs-10">
                    <input type="text" id="cardNo" class="form-control" name="cardNo" placeholder="Enter Card No....." style="max-width:1000px; font-weight:bold" value="<?php echo $cardNo?>">
                </div>
            </div>
            <div class="form-group">
                <label for="bname" class="control-label col-xs-2" style="color:#CCC; font-weight:bold; font-size:20px">Borrower Name</label>
                <div class="col-xs-10">
                    <input type="text" id="bname" class="form-control" name="bname" placeholder="Enter Borrower's name....." style="max-width:1000px; font-weight:bold" value="<?php echo $bname?>">
                </div>
            </div>
            <div class="form-group">
                <label for="isbn" class="control-label col-xs-2" style="color:#CCC; font-weight:bold; font-size:20px">ISBN</label>
                <div class="col-xs-10">
                    <input type="text" id="isbn" class="form-control" name="isbn" placeholder="Enter ISBN number....." style="max-width:1000px; font-weight:bold" value="<?php echo $isbn?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-offset-2 col-xs-10">
                    <button type="submit" class="btn btn-primary" style="color:#FFF; background:#090">Search Loan Record</button>
                </div>
            </div>
        </form> 
<?php
    }
    if($loanid == ''){
        include('mysql_connect.php');
        //if(isset($_GET['isbn']) || isset($_GET['cardNo']) || isset($_GET['bname'])){
        if($isbn != '' || $cardNo != '' || $bname != ''){
            $query = "SELECT * from book, book_authors, borrowers, book_loans where book.isbn=book_loans.isbn and book.isbn=book_authors.isbn and borrowers.card_id=book_loans.card_id and book_loans.date_in IS NULL and (book_loans.card_id like \"%".$cardNo."%\" or borrowers.Bname like \"%".$bname."%\" or book.isbn like \"%".$isbn."%\");"; 
            echo $query;

            $query1 = "SELECT * from book, book_authors, borrowers, book_loans where book.isbn=book_loans.isbn and book.isbn=book_authors.isbn and borrowers.card_id=book_loans.card_id and book_loans.date_in IS NULL and (";
            if($cardNo != ''){
                $query1 = $query1."book_loans.card_id like \"%".$cardNo."%\" or ";
            }else{
                $query1 = $query1."book_loans.card_id IS NULL or ";
            }
            if($bname != ''){
                $query1 = $query1."borrowers.Bname like \"%".$bname."%\" or ";
            }else{
                $query1 = $query1."borrowers.Bname IS NULL or ";
            }if($isbn != ''){
                $query1 = $query1."book.isbn like \"%".$isbn."%\");";
            }else{
                $query1 = $query1."book.isbn IS NULL);";
            }
            echo $query1;
            $result = mysqli_query($con, $query1);
            if($result->num_rows > 0){
?>
           <table class="table table-center-align" style="color:#000; background:#999; max-width:1200px;">
                <caption class="text-right" style="color:#C00; font-style:italic; font-weight:bold; font-size:20px"><?php echo $rowCount;?> Results</caption>  
                <thead>
                    <tr>
                        <th>Loan ID</th>
                        <th>Card No.</th>
                        <th>Borrower Name</th>
                        <th>Book ID</th>
                        <th>Title</th>
                        <th>Checkout Date</th>
                        <th>Due Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>       
            
                    <?php  
                        while($resultarr=mysqli_fetch_array($result)){
                    ?>
                    <tr>
                        <td><?php echo $resultarr['loan_id']; ?></td>
                        <td><?php echo $resultarr['card_id']; ?></td>
                        <td><?php echo $resultarr['Bname']?></td>
                        <td><?php echo $resultarr['isbn']; ?></td>
                        <td><?php echo $resultarr['title']; ?></td>
                        <td><?php echo $resultarr['date_out']?></td>
                        <td><?php echo $resultarr['due_date']?></td>
                        <td>
                            <button type="button" id=" <?php echo $resultarr['loan_id']?> " class="btn btn-primary" style="background:#090;" data-loanid="<?php echo $resultarr['loan_id']; ?>" onClick="checkin(this.id)">Check In</button>
                        <?php
                        }
                        ?>
                        </td>
                    </tr>
                </tbody>
            </table> 
<?php
            }

        }
        mysqli_close($con);
    } else {
        include('mysql_connect.php');
        $query = "SELECT * from book, book_authors, borrowers, book_loans where book.isbn=book_loans.isbn and book.isbn=book_authors.isbn and borrowers.card_id=book_loans.card_id and book_loans.loan_id = '$loanid';";
        echo $query;
        $result2 = mysqli_query($con, $query);
        $resultarr2 = mysqli_fetch_array($result2);
        echo var_dump($resultarr2);
?>
        <table class="table table-center-align" style="color:#000; background:#999; max-width:1200px;">
                <thead>
                        <tr>
                            <th>Loan ID</th>
                            <th>Card No.</th>
                            <th>Book ID</th>
                            <th>Title</th>
                            <th>Checkout Date</th>
                            <th>Due Date</th>
                            <th>Date In</th>
                        </tr>
                </thead> 
                <tbody>       
                        <tr>
                            <td><?php echo $resultarr2['loan_id']; ?></td>
                            <td><?php echo $resultarr2['card_id']; ?></td>
                            <td><?php echo $resultarr2['isbn']; ?></td>
                            <td><?php echo $resultarr2['title']; ?></td>
                            <td><?php echo $resultarr2['date_out']?></td>
                            <td><?php echo $resultarr2['due_date']?></td>
                            <td>
                                <?php
                                    if($resultarr2['date_in'] == NULL)
                                        echo date("Y-m-d");
                                    else
                                        echo $resultarr2['date_in'];
                                ?>
                            </td>
                        </tr>
                </tbody>
            </table> 
                <br>
<?php
        echo date('Y-m-d');
        if($resultarr2['date_in'] == NULL && isset($resultarr2)){
            $query = "UPDATE book_loans set date_in = '".date("Y-m-d")."' where loan_id = '$loanid';";
            echo $query;
            $result3 = mysqli_query($con, $query);

            if($result3){
                ?>
                <p style="color:#090; font-size:18px; font-weight:bold; text-align:center">The book has been successfully checked in. Thanks!&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <a type="button" class="btn" style="background:#090; color:#FFF; font-weight:bold" href="checkin.php">Check In Another Book</a></p>
                <?php
            }
        }else{
            ?>
                <p style="color:#090; font-size:18px; font-weight:bold; text-align:center">The book has been already been checked in. Thanks!&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <a type="button" class="btn" style="background:#090; color:#FFF; font-weight:bold" href="checkin.php">Check In Another Book</a></p>
            <?php
        }
        mysqli_close($con);
    }
?>

<script>
    
function checkin(buttonID){
    var button = document.getElementById(buttonID);
    var loanID = button.getAttribute("data-loanid");
    window.location.href = "checkin.php?loanid=" + loanID;
    
}
</script>
</body>