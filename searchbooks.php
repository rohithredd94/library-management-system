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
    <title>Search Books</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    
     <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="js/jquery-3.2.1.min.js"></script>
    <!--<script src="js/bootstrap.min.js"></script>-->

    <link href="https://fonts.googleapis.com/css?family=Overpass" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
</head>
<body>
    <nav role="navigation" class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
           <div class="navbar-header">
                <a href="welcome.php" class="navbar-brand">Eugene McDermott Library</a>
            </div>
            <div id="navbarCollapse" class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="active"><a href="searchbooks.php">Search Books</a></li>
                    <li><a href="bookloans.php">Book Loans</a></li>
                    <li><a href="addborrower.php">Manage Borrowers</a></li>
                    <li><a href="fines.php">Fines</a></li>
                    <li><a href="reset.php">Log out</a></li>
                </ul>
            </div>
        </div>
        
    </nav>

    <br><br>
    <h1 style="color: black; font-family: 'Overpass',sans-serif; font-weight:700; font-size:55px; text-align:center">SEARCH BOOKS</h1>
    <br>
<?php
    session_start();
    if($_SERVER["REQUEST_METHOD"] == "GET"){
    //if(isset($_GET['search'])){
        if(isset($_GET['search']))
            $search = $_GET['search'];
        else
            $search = '';

    //}
?>
    <form class="form-horizontal" action="searchbooks.php" method="GET">
        <div class="form-group">
            <label for="search" class="control-label col-xs-2" style="color:#000; font-weight:bold; font-size:20px; font-family: 'Raleway', serif;">Search</label>
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
        if($search == '')
            echo "Please enter a search query";
        else{
        include('mysql_connect.php');
        //echo var_dump($con)."<br>";
        $count = substr_count($search, ',');
        if($count == 2){
            $sarr = explode(",", $search);
            //var_dump($sarr);
            $arr['1'] = str_replace(" ","%%",$arr['1']);
            $query = "SELECT DISTINCT(book.isbn) FROM book, book_authors, authors where book.isbn = book_authors.isbn and authors.author_id = book_authors.author_id and (book.isbn like '%".$sarr['0']."%') or (book.title like '%".$sarr['1']."%') or (authors.author_name like '%".$sarr['2']."%') limit 1000;";
            echo $query;
        }elseif($count==1){
            $sarr = explode(",", $search);
            //var_dump($sarr);
            $arr['1'] = str_replace(" ","%%",$arr['1']);
            $query = "SELECT DISTINCT(book.isbn) FROM book, book_authors, authors where book.isbn = book_authors.isbn and authors.author_id = book_authors.author_id and (book.isbn like '%".$sarr['0']."%') or (book.title like '%".$sarr['1']."%' or authors.author_name like '%".$sarr['1']."%') limit 1000;";
            echo $query;
        }else{
            $search = str_replace(" ","%%",$search);
            $query = "SELECT DISTINCT(book.isbn) FROM book, book_authors, authors where book.isbn = book_authors.isbn and authors.author_id = book_authors.author_id and (book.isbn like '%".$search."%' or book.title like '%".$search."%' or authors.author_name like '%".$search."%') limit 1000;";
            echo $query;
        }
        $result = mysqli_query($con, $query);
        //echo var_dump($result);
        if($result->num_rows == 0){
            echo "Nothing matches input string";
            echo "Try entering different words";
        }else{
            echo $result->num_rows;

        //}
        //mysqli_close($con);
    //}
?>
    <table class="table table-center-align" style="color:#000; background:#999; max-width:1200px;">
        <caption class="text-right" style="color:#C00; font-style:italic; font-weight:bold; font-size:20px"><?php echo $result->num_rows;?> Results</caption>  
        <thead>
            <tr>
                <th>Book ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Book Availablity</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
<?php 
            while($resultarr = mysqli_fetch_array($result)){
                $query1 = "SELECT * FROM book_loans where isbn like '%".$resultarr['isbn']."%' and date_in IS NULL;";
                $result1 = mysqli_query($con,$query1);
                if($result1->num_rows > 0){
                    $flag = false;
                    $available = "Not Available";
                }else{
                    $flag = true;
                    $available = "Available";
                }
                //echo $available;
                $query2 = "SELECT * FROM book, book_authors,authors where book.isbn = book_authors.isbn and book_authors.author_id=authors.author_id and book.isbn like '%".$resultarr['isbn']."%';";
                $result2 = mysqli_query($con, $query2);
                while($resultarr1 = mysqli_fetch_array($result2)){
                
?>
            <tr>
                <td><?php echo $resultarr1['isbn']; ?></td>
                <td><?php echo $resultarr1['title']; ?></td>
                <td><?php echo $resultarr1['author_name']; ?></td>
                <td><?php echo $available; ?></td>
                <td>
                    <?php if($flag){
                    ?>
                    <button type="button" id=" <?php echo $resultarr['isbn'];?> " class="btn btn-primary new-button" style="background:#090;" data-isbn="<?php echo $resultarr['isbn']; ?>" data-bookTitle="<?php echo $resultarr['title'];?>" onClick="checkout(this.id)">Checkout</button>
                    <?php
                        }
                    ?>    
                </td>
            </tr>
<?php
                }
            }
        }
        mysqli_close($con);
        }
    }
?>
        </tbody>
    </table>

    <script>
    function checkout(buttonID){
        var button=document.getElementById(buttonID);
        
        var isbn = button.getAttribute("data-isbn");
        var bookTitle = button.getAttribute("data-bookTitle");
        
        window.location.href = 'checkout.php?isbn=' + isbn; 
    }
    </script>

    <footer>
    </footer>
</body>