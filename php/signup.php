<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Yurekha | Signup</title>
    <link href="../css/main.css" rel="stylesheet">
    <link href="../css/up_in.css" rel="stylesheet">
    <link rel="icon" href="../img/favicon.png">

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
                <li><a href="about.html">About Us</a>        </li>
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
                <li class="active"><a href="#"><img src="../img/nav/nav_signup.png" style="vertical-align: bottom">&nbsp;Sign Up</a>
                </li>
                <li><a href="login.php"><img src="../img/nav/nav_login.png" style="vertical-align: bottom">&nbsp;Log In</a>
                </li>
            </ul>
            <!--navigation bar end-->
        </header>

        <!--body content section-->
        <section class="bodyInner">
            <!--sign up forum -->
            <div class="signup_container">
                <form id="signup" action="signup.php" method="post">
                    <h1 align="center">Sign Up</h1>
                    <Lable>Name</Lable>
                    <font size="2" class="warning" color="red"></font>          <!--name warning 0-->
                    <br>
                    <input type="text" id="firstName"  placeholder="First Name" name="firstName">
                    <input type="text" id="lastName"  placeholder="Last Name" name="lastName"><br>


                    <br>
                    <Lable>Address</Lable><br>
                    <textarea rows="4" columns="40" id="address" name="address" placeholder="Address"></textarea>
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
                    <br>
                    <Lable>Birthday</Lable>
                    <font size="2" id="BDwarning" color="red"></font>
                    <br>
=======
=======
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
=======
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
                    <br>
                    <Lable>Birthday</Lable>
                    <font size="2" id="BDwarning" color="red"></font>
                    <br>
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
=======
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
=======
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
                    <input type="date" id="bDay" name="bday" min="1990-01-01" max="2007-12-31">

                    <br>
                    <Lable>Gender</Lable><br>
                    <select id="gender" name="gender">
                        <option hidden>Select</option>
                        <option>Male</option>
                        <option>Female</option>
                    </select>

                    <br>
                    <Lable>Email</Lable>
                    <font size="2" class="warning" color="red"></font>  <!--email warning 1-->
                    <br>
                    <input type="email" id="email" name="email" placeholder="someone@gmail.com">

                    <br>
                    <Lable>Telephone</Lable>
                    <font size="2" class="warning">(*Must contain 10 digits)</font><br> <!--tel warning 2-->
                    <font size="2" class="warning" color="red"></font><br> <!--tel warning 3-->
                    <input type="tel" id="telephoneNo" name="telephone" placeholder="07xxxxxxxx">


                    <br>
                    <Lable>Create a Password</Lable>
                    <font size="2">(*must have 8-16 digits)</font><br>
                    <input type="password" id="password" name="password" placeholder="********">
                    <font size="2" class="warning" color="red"></font><br>              <!--password warning 4-->
                    <br>
                    <Lable>Confirm Password</Lable>
                    <br>
                    <input type="password" id="confirmPassword" name="cmfPassword"  placeholder="********">


                    <input type="checkbox" id="agreement"><label for="agreement" id="agreementStatement"> I agree with the conditions of Yureka Institute.</label>
                    <br>
                    <input type="submit" value="Submit" onclick="validateOnclick();" >
                    <!--onclick="submitOnclick();" for validations"-->

                    <!--Index container -->
                       <div id="id01" class="modal">
                              <div class="modal-content animate">
                                        <div class="imgcontainer">
                                                <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
                                            </div>
                                        <div class="container">
                                               <label><b>Enter Index Number</b></label>
                                               <input type="text" placeholder="Index Number" name="indexNum" required>
                                       <input type="submit" name="finalSubmit" value="Done">
                                               <center><a href="signup.php" style="font-size: small" title="click if you don't have an Index number from Institute">I don't have an Index Number</a></center>
                                           </div>
                                   </div>
                          </div>
                       <!---->

                </form>
            </div>
            <!--sign up forum -->
        </section>

        <!--footer section-->
        <footer>
            <hr class="hr1">
            <hr class="hr2">
            <p align="center" style="font-size: small;" title="Yureka Higher Education Institute"><a href="../index.php" >Yureka Higher Education Institute</a> All Rights Reserved.</p>
        </footer>
    </div>
<script src="../javascript/validations/signupValidations.js"></script>
<script src="../javascript/validations/Validations.js"></script>
<!--php code here-->
<?php
require_once("connection/dbConnection.php");

if(isset($_POST['finalSubmit'])) {
    $index = $_POST['indexNum'];
    if($index!=null) {
        $query_check = "SELECT * FROM student WHERE indexNumber ='$index' ";
        $result = runQuery($query_check);

        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $address = $_POST['address'];
        $bday = $_POST['bday'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];
        $telephone = $_POST['telephone'];
        $password = $_POST['password'];
        $cmfPass = $_POST['cmfPassword'];

        $encriptedPass = sha1($cmfPass);

        //check for valid index number
        if (mysqli_num_rows($result) == 1) {
            $result = mysqli_fetch_assoc($result);
            //already registered check
            if ($result['firstName'] == null && $result['lastName'] == null) {
                $query_store = "UPDATE student SET firstName='$firstName',lastName='$lastName',address='$address',birthDay='$bday',gender='$gender',email='$email',telephone='$telephone',password='$encriptedPass' WHERE indexNumber='$index'";

                $filledCheck = strlen($firstName) != 0 && strlen($lastName) != 0 && strlen($address) != 0 && strlen($bday) != 0 && strlen($gender) != 0 && strlen($email) != 0 && strlen($telephone) != 0 && strlen($password) != 0 && strlen($cmfPass) != 0;
                //save data when validation is success
                if ($filledCheck) {
                    $save = runQuery($query_store);
                    echo "<script>alert('Successfully registered!'); </script>";
                }
            } else {
                echo "<script>alert('You already registered!');</script>";
            }
        } else {
            echo "<script>alert('Invalid Index Number!');</script>";

        }
    }
}
?>
<!--php code here-->

</body>
</html>