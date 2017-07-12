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
    <link href="css/styles.css" rel="stylesheet">
    <script src="js/jquery-3.2.1.min.js"></script>
    <!--<script src="js/bootstrap.min.js"></script>-->
    <script src="js/check.js"></script>
    <link rel="stylesheet" href="css/validate.css">
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://fonts.googleapis.com/css?family=Overpass" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Pangolin" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link rel="icon" href="logo.png" type="image/png">
    <style>
        p.info1{
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
                    <li><a href="bookloans.php">Book Loans</a></li>
                    <li><a href="addborrower.php">Manage Borrowers</a></li>
                    <li class="active"><a href="fines.php">Fines</a></li>
                    <li><a href="reset.php">Log out</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div id="wrap">
<?php
    include('mysql_connect.php');

    $query = "SELECT * FROM fines;";
    $result = mysqli_query($con, $query);
    $finesarr = $result->fetch_all();

    $finelist[] = "";
    $paidlist[] = "";
    foreach ($finesarr as $fine) {

        $finelist[] = $fine[0];
        $paidlist[] = $fine[2];
    }
    $query = "SELECT * FROM book_loans WHERE (due_date < date_in AND date_in IS NOT NULL) OR (date_in IS NULL AND due_date < '".date("Y-m-d")."');";
    //echo $query;

    $result2 = mysqli_query($con, $query);

    while($resultarr = mysqli_fetch_array($result2)){

        $duedate = new DateTime($resultarr['due_date']);
        if($resultarr['date_in'] == NULL){
            $currdate = new DateTime(date("Y-m-d"));
            $d = date_diff($duedate, $currdate);
        }else{
            $currdate = new DateTime($resultarr['date_in']);
            $d = date_diff($duedate,$currdate);
        }
        
        $e = $d->format("%R%a days");
        $d = explode("+", $e);
        $daydiff=explode(" ", $d[1]);
        $daydiff=$daydiff[0];

        if(array_search($resultarr['loan_id'], $finelist) == FALSE) {
            //echo "Not in fines"."<br>";
            $fineamt = $daydiff * 0.25;
            $query = "INSERT INTO fines(loan_id,fine_amt, paid) VALUES('".$resultarr['loan_id']."', '".$fineamt."','0');";
            //echo $query;
            $result3 = mysqli_query($con,$query);
            
        }else{
            //echo "In fines"."<br>";
            $index = array_search($resultarr['loan_id'], $finelist);
            if($paidlist[$index] == '0'){
                $query = "UPDATE FINES SET fine_amt = '".$daydiff*0.25."' WHERE loan_id = '".$resultarr['loan_id']."';";
                //echo $query;
                $result3 = mysqli_query($con,$query);
            }
        }

    }
?>

<?php
    if(!isset($_GET['filter'])){
?>
        <p class="info1">FINES TABLE UPDATED. Here is a list of all outstanding fines:  </p> 
<?php
        $query = "SELECT book_loans.card_id, borrowers.Bname, SUM(fines.fine_amt) as fine from fines,book_loans,borrowers WHERE fines.loan_id = book_loans.loan_id AND book_loans.card_id=borrowers.card_id and paid = '0' group by book_loans.card_id;";
        //echo $query;
        $result4 = mysqli_query($con,$query);
        //var_dump($result4);
?>
        <table class="table table-center-align">
        
            <thead>
                <tr>
                    <th>Card No.</th>
                    <th>Name</th>
                    <th>Fine Amount</th>
                </tr>
            </thead>
            <tbody>
<?php
            while($resultarr2 = mysqli_fetch_array($result4)){
?>
                <tr>
                    <td><?php echo $resultarr2['card_id']; ?></td>
                    <td><?php echo $resultarr2['Bname']; ?></td>
                    <td><?php echo $resultarr2['fine']; ?></td>
                </tr>
<?php
            }
?>
            </tbody>
        </table>
        <br>
        <p class="info1"><a type="button" class="btn btn-primary new-button" href="fines.php">Done</a></p>
<?php
    }
    mysqli_close($con);
?>
    <div class="push"></div>
    </div>
    <footer>
        <p>Design and Development by Rohith Reddy K</p>
    </footer>
</body>
</html>