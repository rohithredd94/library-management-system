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
    <title>Add Borrower</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    
     <!-- CSS -control-->
    <link href="css/styles.css" rel="stylesheet">
    <script src="js/jquery-3.2.1.min.js"></script>
    <!--<script src="js/bootstrap.min.js"></script>-->
    <script src="js/check.js"></script>
    <link rel="stylesheet" href="validate.css">
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css?family=Overpass" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Pangolin" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link rel="icon" href="logo.png" type="image/png">
    <style>
        p.info1{
            color:#F60; font-size:18px; font-weight:bold; text-align:left;
        }
        .col-lg-10{
            padding: 0;
        }
        .new-button:hover{
            background-color:#F60;
        }
        input{
            width: 100%;
            max-width: 100%;
            font-weight: bold;
        }
        #error{
            color:#F60; font-size:18px; font-weight:bold; text-align:left; list-style-type: none;
        }
        div.col-xs-10,div.col-xs-4{
            padding-top: 5px;
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
                    <li class="active"><a href="addborrower.php">Manage Borrowers</a></li>
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
            <h1 class="main-heading">Manage Borrowers</h1>
        </div>
        <div class="col-lg-2">
            <p>Today's date is <?php echo date('Y-m-d');?></p>
        </div>
    </div>
    <br><br>

<?php
    //Didnt receive any values of atleast of one the following
    if(!isset($_GET['fname']) && !isset($_GET['lname']) && !isset($_GET['address']) && !isset($_GET['city']) && !isset($_GET['state']) && !isset($_GET['ssn']) && !isset($_GET['phone'])) {
?>
        <br>
        <div class="col-lg-12">
        <div class="col-lg-offset-2 col-lg-8">
        <form class="form-horizontal" action="addborrower.php" method="get">
        <p class="info1">Enter the following information to register new borrower</p>
        <div class="form-group">
            <label for="fname" class="control-label col-xs-2">First Name *</label>
            <div class="col-xs-4">
                <input type="text" id="fname" class="form-control input-ctrl" name="fname" maxlength="12" placeholder="Enter First Name....." required>
            </div>
            <label for="lname" class="control-label col-xs-2">Last Name *</label>
            <div class="col-xs-4">
                <input type="text" id="lname" class="form-control" name="lname" maxlength="13" placeholder="Enter Last name....." required>
            </div>
        </div>
        <div class="form-group">
            <label for="address" class="control-label col-xs-2">Address *</label>
            <div class="col-xs-10">
                <input type="text" id="address" class="form-control" name="address" maxlength="40" placeholder="Enter Address....." required>
            </div>
        </div>
        <div class="form-group">
            <label for="city" class="control-label col-xs-2">City *</label>
            <div class="col-xs-4">
                <input type="text" id="city" class="form-control" name="city" maxlength="18" placeholder="Enter City....." required>
            </div>
            <label for="state" class="control-label col-xs-2">State *</label>
            <div class="col-xs-4">
                <input type="text" id="state" class="form-control" name="state" maxlength="2" placeholder="Enter State....." required>
            </div>
        </div>
        <div class="form-group">
            <label for="ssn" class="control-label col-xs-2">SSN *</label>
            <div class="col-xs-4">
                <input type="text" id="ssn" class="form-control" name="ssn" maxlength="9" placeholder="Enter ssn....." required>
            </div>
            <label for="phone" class="control-label col-xs-2">Phone *</label>
            <div class="col-xs-4">
                <input type="text" id="phone" class="form-control" name="phone" maxlength="10" placeholder="Enter Phone....." required>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-10">
                <button type="submit" class="btn btn-primary new-button">Register</button>
            </div>
        </div>
        </form>
        </div>
        </div> 
<?php
    }else{
        include('mysql_connect.php');
        if (isset($_GET['fname'])){
            $fname=$_GET['fname'];
            if(preg_match("/^[a-zA-Z0-9 ]+$/", $fname))
                $flagfname = true;
            else
                $flagfname = false;
        }
        else
            $fname='';

        //echo var_dump($flagfname);
            
        if (isset($_GET['lname'])){
            $lname=$_GET['lname'];
            if(preg_match("/^[a-zA-Z0-9 ]+$/", $lname))
                $flaglname = true;
            else
                $flaglname = false;
        }
        else
            $lname='';
        //echo var_dump($flaglname);

        if (isset($_GET['address'])){
            $address=$_GET['address'];
            if(preg_match("/^[a-zA-Z0-9 ]+$/", $address))
                $flagaddress = true;
            else
                $flagaddress = false;
        }
        else
            $address='';
        //echo var_dump($flagaddress);

        if (isset($_GET['city'])){
            $city=$_GET['city'];
            if(preg_match("/^[a-zA-Z0-9 ]+$/", $city))
                $flagcity = true;
            else
                $flagcity = false;
        }
        else
            $city='';
        //echo var_dump($flagcity);

        if (isset($_GET['state'])){
            $state=$_GET['state'];
            if(preg_match("/^[a-zA-Z0-9]{2}$/", $state))
                $flagstate = true;
            else
                $flagstate = false;
        }
        else
            $state='';
        //echo var_dump($flagstate);

        if (isset($_GET['ssn'])){
            $ssn=$_GET['ssn'];
            if(preg_match("/^[0-9]+$/", $ssn))
                $flagssn = true;
            else
                $flagssn = false;
        }
        else
            $ssn='';
        //echo var_dump($flagssn);

        if (isset($_GET['phone'])){
            $phone=$_GET['phone'];
            if(preg_match("/^[0-9]+$/", $phone))
                $flagphone = true;
            else
                $flagphone = false;
        }
        else
            $phone='';
        //echo var_dump($flagphone);

        if(!$flagfname || !$flaglname || !$flagaddress || !$flagcity || !$flagstate || !$flagssn || !$flagphone){
?>
        <div class="col-lg-12">
        <div class="col-lg-offset-2 col-lg-8">
            <form class="form-horizontal" action="addborrower.php" method="get">
        <p class="info1">Enter the following information to register new borrower</p>
        <div class="form-group">
            <label for="fname" class="control-label col-xs-2">First Name *</label>
            <div class="col-xs-4">
                <input type="text" id="fname" class="form-control" name="fname" maxlength="12" placeholder="Enter First Name....." value="<?php echo $fname; ?>" required>
            </div>
            <label for="lname" class="control-label col-xs-2">Last Name *</label>
            <div class="col-xs-4">
                <input type="text" id="lname" class="form-control" name="lname" maxlength="13" placeholder="Enter Last name....." value="<?php echo $lname; ?>" required>
            </div>
        </div>
        <div class="form-group">
            <label for="address" class="control-label col-xs-2">Address *</label>
            <div class="col-xs-10">
                <input type="text" id="address" class="form-control" name="address" maxlength="40" placeholder="Enter Address....." value="<?php echo $address; ?>" required>
            </div>
        </div>
        <div class="form-group">
            <label for="city" class="control-label col-xs-2">City *</label>
            <div class="col-xs-4">
                <input type="text" id="city" class="form-control" name="city" maxlength="18" placeholder="Enter City....." value="<?php echo $city; ?>" required>
            </div>
            <label for="state" class="control-label col-xs-2">State *</label>
            <div class="col-xs-4">
                <input type="text" id="state" class="form-control" name="state" maxlength="2" placeholder="Enter State....." value="<?php echo $state; ?>" required>
            </div>
        </div>
        <div class="form-group">
            <label for="ssn" class="control-label col-xs-2">SSN *</label>
            <div class="col-xs-4">
                <input type="text" id="ssn" class="form-control" name="ssn" maxlength="9" placeholder="Enter ssn....." value="<?php echo $ssn; ?>" required>
            </div>
            <label for="phone" class="control-label col-xs-2">Phone *</label>
            <div class="col-xs-4">
                <input type="text" id="phone" class="form-control" name="phone" maxlength="10" placeholder="Enter Phone....." value="<?php echo $phone; ?>" required>
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-offset-2 col-xs-10">
                <button type="submit" class="btn btn-primary new-button">Register</button>
            </div>
        </div>
        </form>
        </div>
        </div>
        <div class="col-lg-12">
        <div class="col-lg-offset-2 col-lg-8">
        <p class="info1">The user could not be registered. Please correct the following fields
            <ul id="error">
                <li><?php if(!$flagfname){echo 'First Name'.'<br>';} ?></li>
                <li><?php if(!$flaglname){echo 'Last Name'.'<br>';} ?></li>
                <li><?php if(!$flagaddress){echo 'Address'.'<br>';} ?></li>
                <li><?php if(!$flagcity){echo 'City'.'<br>';} ?></li>
                <li><?php if(!$flagstate){echo 'State'.'<br>';} ?></li>
                <li><?php if(!$flagssn){echo 'SSN'.'<br>';} ?></li>
                <li><?php if(!$flagphone){echo 'Phone'.'<br>';} ?></li>
            </ul>
        </p>
        </div>
        </div>
<?php
        
        }else{
            $newssn = substr($ssn, 0, 3).'-'.substr($ssn,3,2).'-'.substr($ssn, 5);
            $query = "SELECT * FROM borrowers where ssn = '$newssn';";
            $result = mysqli_query($con, $query);
            if($result == FALSE) {
?>
                <p class="info1">Failed to query database. Please try again.</p>
<?php
            }elseif($result->num_rows == 1) {//User already found given SSN
?>
        <div class="col-lg-12">
        <div class="col-lg-offset-2 col-lg-8">
                <form class="form-horizontal" action="addborrower.php" method="get">
        <p class="info1">A user already exists with the given SSN. Please try again.</p>
        <div class="form-group">
            <label for="fname" class="control-label col-xs-2">First Name *</label>
            <div class="col-xs-4">
                <input type="text" id="fname" class="form-control" name="fname" maxlength="12" placeholder="Enter First Name....." value="<?php echo $fname; ?>" required>
            </div>
            <label for="lname" class="control-label col-xs-2">Last Name *</label>
            <div class="col-xs-4">
                <input type="text" id="lname" class="form-control" name="lname" maxlength="13" placeholder="Enter Last name....." value="<?php echo $lname; ?>" required>
            </div>
        </div>
        <div class="form-group">
            <label for="address" class="control-label col-xs-2">Address *</label>
            <div class="col-xs-10">
                <input type="text" id="address" class="form-control" name="address" maxlength="40" placeholder="Enter Address....." value="<?php echo $address; ?>" required>
            </div>
        </div>
        <div class="form-group">
            <label for="city" class="control-label col-xs-2">City *</label>
            <div class="col-xs-4">
                <input type="text" id="city" class="form-control" name="city" maxlength="18" placeholder="Enter City....." value="<?php echo $city; ?>" required>
            </div>
            <label for="state" class="control-label col-xs-2">State *</label>
            <div class="col-xs-4">
                <input type="text" id="state" class="form-control" name="state" maxlength="2" placeholder="Enter State....." value="<?php echo $state; ?>" required>
            </div>
        </div>
        <div class="form-group">
            <label for="ssn" class="control-label col-xs-2">SSN *</label>
            <div class="col-xs-4">
                <input type="text" id="ssn" class="form-control" name="ssn" maxlength="9" placeholder="Enter ssn....." value="<?php echo $ssn; ?>" required>
            </div>
            <label for="phone" class="control-label col-xs-2">Phone *</label>
            <div class="col-xs-4">
                <input type="text" id="phone" class="form-control" name="phone" maxlength="10" placeholder="Enter Phone....." value="<?php echo $phone; ?>" required>
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-offset-2 col-xs-10">
                <button type="submit" class="btn btn-primary new-button">Register</button>
            </div>
        </div>
        </form>
        </div>
        </div>
<?php
            }else{//Didn't find SSN, so user can be registered
                $query = "SELECT MAX(card_id) from borrowers;";
                $result2 = mysqli_query($con, $query);

                $resultarr = mysqli_fetch_array($result2);

                $id = substr($resultarr['MAX(card_id)'],2);
                $id = (int)$id + 1;
                $id = str_pad($id, 6, '0', STR_PAD_LEFT);
                $id = "ID".$id;
                //echo $id;
                $ssn = substr($ssn, 0, 3).'-'.substr($ssn,3,2).'-'.substr($ssn, 5);
                $phone = '('.substr($phone, 0,3).') '.substr($phone, 3,3).'-'.substr($phone, 6);
                $bname = $fname . ' ' . $lname;
                $fulladdress = $address.','.$city.','.$state;

                $query = "INSERT INTO borrowers (card_id, ssn, Bname, Address, Phone) VALUES ('$id','$ssn', '$bname', '$fulladdress','$phone');";
                //echo $query;

                $result3 = mysqli_query($con, $query);

                if(!$result3){
?>
                    <p class="info1">Oops! The user could not be registered. Please try again.</p>
<?php
                }else{
                    $query = "SELECT MAX(card_id) from borrowers;";
                    $result4 = mysqli_query($con, $query);

                    $resultarr2 = mysqli_fetch_array($result4);
                    $max_card_id = $resultarr2['MAX(card_id)'];

                    $query = "SELECT * FROM borrowers where card_id = '$max_card_id';";
                    $result5 = mysqli_query($con, $query);

                    $resultarr3 = mysqli_fetch_array($result5);

?>      
                    <div class="col-lg-12">
                    <div class="col-lg-offset-2 col-lg-8">
                    <p class="info1"><i>Congrats!</i> You are now a member of this library. You can checkout AT MOST 3 books at any time. All books are checked out for 14 days.</p>
                    <table class="table table-center-align">
                        <caption class="text-left">Registration Details:</caption>  
                        <thead>
                        <tr>
                            <th>Card No.</th>
                            <th>SSN</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Phone No.</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $resultarr3['card_id']; ?></td>
                                <td><?php echo $resultarr3['Ssn'] ?></td>
                                <td><?php echo $resultarr3['Bname']; ?></td>
                                <td><?php echo $resultarr3['Address']; ?></td>
                                <td><?php echo $resultarr3['Phone']; ?></td>
                            </tr>
             
                        </tbody>
                    </table>
                    </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-offset-2 col-xs-10">
                            <a href="addborrower.php" class="btn btn-primary new-button">Done</a></li>
                        </div>
                    </div>
<?php
                }


            }

        }
        mysqli_close($con);
    }
?>
    <div class="push"></div>
    </div>
    <footer>
        <p>Design and Development by Rohith Reddy K</p>
    </footer>
</body>
</html>