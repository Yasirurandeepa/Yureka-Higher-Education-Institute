<?php ob_start();session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Yurekha | Login</title>
    <link rel="icon" href="../img/favicon.png">
    <link href="../css/main.css" rel="stylesheet">
    <link href="../css/up_in.css" rel="stylesheet">
</head>
<body bgcolor="#e3e6ea">
<div class="content">
        <!--header section-->
        <header>
            <center><img src="../img/Yureka%20logo.png" id="mainLogo"></center>
            <!--navigation bar start-->
            <ul class="nav">
                <li><a href="../index.php"><img src="../img/nav/nav_yureka_logo.png"></a></li>
                <li><a href="courses.php">Courses</a></li>
                <li><a href="about.html">About Us</a></li>
<<<<<<< HEAD
<<<<<<< HEAD
                <li><a href="contact.html">Contact Us</a></li>
=======
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
<<<<<<< HEAD
                <li><a href="contact.html">Contact Us</a></li>
=======
=======
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
                <li><a href="#">Contact Us</a></li>
>>>>>>> d16f7e303373f7aa06afeff3a1c36aeb8d5b1a6a
=======
                <li><a href="#">Contact Us</a></li>
>>>>>>> d16f7e303373f7aa06afeff3a1c36aeb8d5b1a6a
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
=======
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
=======
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
                <li><a href="signup.php"><img src="../img/nav/nav_signup.png" style="vertical-align: bottom">&nbsp;Sign Up</a>
                </li>
                <li class="active"><a href="login.php"><img src="../img/nav/nav_login.png" style="vertical-align: bottom">&nbsp;Log
                        In</a></li>
            </ul>
            <!--navigation bar end-->
        </header>

        <!--body content section-->
        <section class="bodyInner">
            <!--Log In forum -->
            <div class="wrapper">
                <form action="login.php" method="post">
                    <h1 align="center">Log In</h1>
                    <center><img src="../img/avatar.png" id="avatar" width="50%" height="50%"></center>
                    <br>
                    <input type="text" id="login_username" placeholder="Index Number" name="loginUsername" value="<?php if (isset($_COOKIE['username_log'])) {
                        echo $_COOKIE['username_log'];
                    }?>"><br>
                    <input type="password" id="login_password" placeholder="Password" name="loginPassword" value="<?php if (isset($_COOKIE['password_log'])) {
                        echo $_COOKIE['password_log'];
                    }?>"> <br>
                    <input type="checkbox" id="keepMeLogin" name="keepMeLogin"><label for="keepMeLogin">Remember me</label>
                    <a href="#" class="forgetpsw" title="Frogot your password ?" name="forgetPassword" onclick="document.getElementById('frgt').style.display='block'">Forget Password?</a><br>
                    <input type="submit" value="Log In" name="loginBtn" ><br>
                </form>
                <form action="login.php" method="post">
                     <!--forget password -->
                       <div id="frgt" class="modal">
                              <div class="modal-content animate">
                                        <div class="imgcontainer">
                                                <span onclick="document.getElementById('frgt').style.display='none'" class="close" title="Close Modal">&times;</span>
                                            </div>
                                        <div class="container">
                                               <label><b>Enter Index Number</b></label>
                                               <input type="text" placeholder="Index Number" name="forgetIndex" required>
                                       <input type="submit" name="forgot" value="Done">
                                              
                                           </div>
                                   </div>
                          </div>
                       <!---->
                </form>
            </div>
            <!--Log In forum -->
        </section>
        <!--footer section-->
        <footer>
            <hr class="hr1">
            <hr class="hr2">
            <p align="center" style="font-size: small;" title="Yureka Higher Education Institute"><a href="../index.php" >Yureka Higher Education Institute</a> All Rights Reserved.</p>
        </footer>
    </div>

<?php

require_once("connection/dbConnection.php");
require("notifications/notifications.php");

function submitOnclick()
{
    global $connection;
    // echo "<script type='text/javascript'>fieldColorChange(document.getElementsByClassName('login_username'),'');fieldColorChange(document.getElementsByClassName('login_password'),'');</script>";
    
    $username = $_POST['loginUsername'];
    $password = sha1($_POST['loginPassword']);

    $char = strtoupper(substr($username, -1));
    $query = "";
    switch ($char) {
        case 'S':
            $query = "SELECT * FROM student WHERE password='{$password}' AND indexNumber ='{$username}'";
            break;
        case 'T':
            $query = "SELECT * FROM teacher WHERE password='{$password}' AND indexNumber ='{$username}'";
            break;
        case 'O':
            $query = "SELECT * FROM owner WHERE password='{$password}' AND indexNumber ='{$username}'";
            break;
        default:
            echo "<script type='text/javascript'>alert('Invalid type user!'); fieldColorChange(document.getElementById('login_username'),'red');</script>";
            break;
    }

    if ($query != "") {
        $result_set = runQuery($query);
        if (mysqli_num_rows($result_set) == 1) {
            switch ($char) {
                case "S":
                    $_SESSION['username'] = $username;
                    $_SESSION['password'] = $password;
                    $_SESSION['logged'] = true;
                    header("location: student.php"); // Redirecting To Other Page
                    break;
                case "T":
                    $_SESSION['username'] = $username;
                    $_SESSION['password'] = $password;
                    $_SESSION['logged'] = true;
                    header("location: teacher.php"); // Redirecting To Other Page
                    break;
                case "O":
                    $_SESSION['username'] = $username;
                    $_SESSION['password'] = $password;
                    $_SESSION['logged'] = true;
                    header("location: owner.php"); // Redirecting To Other Page
                    break;
                default:
                    echo "<script type='text/javascript'>alert('Invalid Index Number or Password !'); fieldColorChange(document.getElementById('login_username'),'red'); fieldColorChange(document.getElementById('login_password'),'red');</script>";
                    break;

            }

          
        }else{
            echo "<script type='text/javascript'>alert('Invalid Index Number or Password !'); fieldColorChange(document.getElementById('login_username'),'red'); fieldColorChange(document.getElementById('login_password'),'red');</script>";
        }
//window.location.href = 'login.php';
    }
}
if (isset($_POST['loginBtn'])) {
     if(isset($_POST["keepMeLogin"])) {
        $username = $_POST['loginUsername'];
        $cookiepass=$_POST['loginPassword'];
      
                setcookie ("username_log",$username,time()+ (10 * 365 * 24 * 60 * 60));
                setcookie ("password_log",$cookiepass,time()+ (10 * 365 * 24 * 60 * 60));

            } 
    submitOnclick();
}




if (isset($_POST['forgot'])) {
    $indexNo=$_POST['forgetIndex'];
    if ($indexNo!=null ) {

        $query_check = "SELECT * FROM student WHERE indexNumber ='$indexNo'";
        $result = runQuery($query_check);

        if (mysqli_num_rows($result)==1) {
            $result= mysqli_fetch_assoc($result);
            $email=$result['email'];
            $number='';
            for ($i = 0; $i<8; $i++) {
                    $number .= mt_rand(0,9);
                }
        $num=sha1($number);     
        $sql="UPDATE student SET password='$num' WHERE indexNumber='$indexNo'"; 
        runQuery($sql); 
        sendMail($email,'Your Password reset by',"As your request on ".date("Y/m/d")." at ".date("h:i:sa")." to password reset, we have reset your password.Therefore this is the recovery password issued by the Yureka Institute Online System <br><br><h1 align='center' style='background-color:lightgray; color:#4CAF50; width:400px; padding:20px; border:solid 4px gray; border-radius:50px; margin-left:20%; margin-top: 50px; margin-bottom: 50px;'>New Password : ".$number."</h1><br>If you want to change this, do it after you logged your account.", "Yureka Institute");

        echo "<script>alert('Successfully sent the recovery  password to your email address!'); </script>";
        
            
        }
        else{
            echo "<script type='text/javascript'>alert('Invalid Index Number  !'); fieldColorChange(document.getElementById('index'),'red');</script>";
        }
        echo '<script>window.location.href = "login.php";</script>';
        exit();
    }
}
?>
</body>
</html>