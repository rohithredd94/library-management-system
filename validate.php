<?php
    session_start();
    $con = mysqli_connect("localhost","root","8765","library");
    if(mysqli_connect_errno()){
        echo "Failed to Connect to mysql".mysql_connect_error();
    }else{
        echo "Connection Successfull"."<br>";
    }
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $_SESSION = array();
        if(!empty($_POST["username"]) && !empty($_POST["password"])){
            $username = $_POST["username"];
            $password = $_POST["password"];
            //$username = mysql_real_escape_string($username);
            $query = "SELECT username, password, name FROM auth_users WHERE username = '$username';";
            $result = mysqli_query($con, $query);
            if($result->num_rows == 0){
                //echo "User not found";
                $_SESSION['error'] = 'User not found';
                header('Location: login.php');
                exit();
            }
            $userdata = mysqli_fetch_array($result, MYSQLI_ASSOC);
            //$hash = hash('sha256', hash('sha256', $password));
            //echo $hash;
            if($password != $userdata['password']){
                //echo "Incorrect password";
                $_SESSION['error'] = 'Incorrect password';
                header('Location: login.php');
                exit();
            }else{
                session_regenerate_id();
                $_SESSION['username'] = $userdata['username'];
                $_SESSION['name'] = $userdata['name'];
                //$_SESSION['avatar'] = $userdata['avatar'];
                session_write_close();
                header('Location: welcome.php');
                exit();
            }
        }else{
            //echo "Input fields missing";
            $_SESSION['error'] = 'Please fill all the input fields';
            header('Location: login.php');
            exit();
        }
    }else{
        header('Location: login.php');
        exit();
    }
    mysqli_close($con);
?>