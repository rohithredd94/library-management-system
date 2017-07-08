<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Search Books</title>

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
                <a href="index.php" class="navbar-brand">Eugene McDermott Library</a>
            </div>
            <div id="navbarCollapse" class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="active"><a href="searchbooks.php">Search Books</a></li>
                    <li><a href="bookloans.php">Book Loans</a></li>
                    <li><a href="addborrower.php">Manage Borrowers</a></li>
                    <li><a href="fines.php">Fines</a></li>
                </ul>
            </div>
        </div>
        
    </nav>

    <br><br>
    <h1 style="color: black; font-family: sans-serif; font-weight:700; font-size:55px; text-align:center">SEARCH BOOKS</h1>
    <br>
<?php
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        if(isset($_GET['search']))
            $search = $_GET['search'];
        else
            $search = '';

    //}
?>
    <form class="form-horizontal" action="searchbooks.php" method="GET">
        <div class="form-group">
            <label for="search" class="control-label col-xs-2" style="color:#CCC; font-weight:bold; font-size:20px">Search</label>
            <div class="col-xs-10">
                <input type="text" class="form-control" name="search" placeholder="..." style="max-width:1000px; font-weight:bold" value="<?php echo $search?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-offset-2 col-xs-10">
                <button type="submit" class="btn btn-primary custom-button" style="background:#F00; font-weight:bold">Search</button>
            </div>
        </div>
    </form> 
<?php
        include('mysql_connect.php');
        echo var_dump($con)."<br>";
        $query = "SELECT * FROM book, book_authors, authors where book.isbn = book_authors.isbn and authors.author_id = book_authors.author_id and (book.isbn like '%".$search."%' or book.title like '%".$search."%');";
        echo $query;
        $result = mysqli_query($con, $query);
        //echo var_dump($result);
        if($result->num_rows == 0){
            echo "Nothing matches input string";
            echo "Try entering different words";
        }else{
            echo $result->num_rows;
        }
        mysqli_close($con);
    }
?>

    <footer>
        <a id="reset" href="reset.php" class="btn btn-default btn-xs custom-button" style="bottom:1%; position:absolute; font-weight:bold">Log out</a>
    </footer>
</body>