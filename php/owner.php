<!--php code here-->
<?php require("connection/dbConnection.php");
require("notifications/notifications.php");
///////Load user data//////////////////////////////////////////////////////////////////////////////////////////
session_start();
$query = "SELECT * FROM owner WHERE indexNumber='{$_SESSION["username"]}' AND password='{$_SESSION["password"]}'";
$result = runQuery($query);
if (mysqli_num_rows($result) == 1 && $_SESSION['logged']) {
    $data = mysqli_fetch_assoc($result);
    $fullName = $data['firstName'] . " " . $data['lastName'];

///////////////////////////////New Student////////////////////////////////////////////////////////////
    function indexGenerate()
    {
        $query = "SELECT id FROM student ORDER BY id DESC LIMIT 1";
        $result_set = runQuery($query);
        if ($result_set) {
            $result_set = mysqli_fetch_assoc($result_set);
            $raw = $result_set['id'] + 1;
            $raw = strval($raw);
            $year = substr(strval(date("Y")), -2);
            if (strlen($raw) == 1) {
                return $year . "000" . $raw . "S";
            } else if (strlen($raw) == 2) {
                return $year . "00" . $raw . "S";
            } else if (strlen($raw) == 3) {
                return $year . "0" . $raw . "S";
            } else if (strlen($raw) == 4) {
                return $year . $raw . "S";
            } else {
                return "System reached the maximum number of users !";
            }

        }
    }


    if (isset($_POST['issue'])) {
        $indexNo = $_POST['index'];
        $stuMail = $_POST['stumail'];
        $query = "INSERT INTO student (indexNumber,profilePic) VALUES ('$indexNo','../img/profilePics/16401b92e208d08bd8d0e064441977fc713bf45d.png')";
        runQuery($query);
        if (strlen(trim($stuMail)) > 0) {
            sendMail($stuMail, "Your Registration Index Number of ", "Welcome to Yureka Institute online System ! <br><br>This is a valid index number issued by Yureka Higner Education Institute.If you have any problem with registration please contact our office. <br><h1 align='center' style='background-color:lightgray; color:#4CAF50; width:400px; padding:20px; border:solid 4px gray; border-radius:50px; margin-left:20%; margin-top: 50px; margin-bottom: 50px;'>Index Number : " . $indexNo . "</h1><br><a href='#'>Yureka Higher Education Institute</a> All Rights Reserved!", "Yureka Institute");
        }
        echo '<script>window.location.href = "owner.php";</script>';
        exit();
    }


///////////////////////////////New Student////////////////////////////////////////////////////////////


///////////////////////////////Courses////////////////////////////////////////////////////////////

/////////////////////////////// Add Courses////////////////////////////////////////////////////////////

    $weekDays_DD = "<option>Sunday</option>
                                <option>Monday</option>
                                <option>Tuesday</option>
                                <option>Wednesday</option>
                                <option>Thursday</option>
                                <option>Friday</option>
                                <option>Saturday</option>";

    $availableHalls_DD = "<option>Hall No:1</option>
                                <option>Hall No:2</option>
                                <option>Hall No:3</option>";

    $availableSubjects_DD = "";

    if (isset($_POST['doneAdd'])) {
        if($_POST['upPass'] == $_SESSION['password']) {
            $query_courseAdd = "INSERT INTO courses (subject, teacher, classDay, classTime, hall) VALUES ('{$_POST["subject"]}','{$_POST["teacher"]}','{$_POST["classDay"]}','{$_POST["classTime"]}','{$_POST["hall"]}')";
            runQuery($query_courseAdd);
            echo "<script type='text/javascript'>alert('Course Successfully Added !');</script>";
            echo '<script>window.location.href = "owner.php";</script>';
            exit();
        }
    }

    $availableTeachers = "";
    $query_teacher = "SELECT * FROM teacher";
    $teachers = runQuery($query_teacher);
    if (mysqli_num_rows($teachers) > 0) {
        while ($teacher = mysqli_fetch_assoc($teachers)) {
            $availableTeachers .= "<option>{$teacher['firstName']} {$teacher['lastName']}</option>";
        }
    } else {
        $availableTeachers = "<option>No Teachers</option>";
    }

/////////////////////////////// Add Courses////////////////////////////////////////////////////////////

///////////////////////////////Update Courses////////////////////////////////////////////////////////////

//>>>>>>>>>>>>>>Load Data <<<<<<<<<<<<<<<<<<<<<<<<<
    $query_courseUp = "SELECT * FROM courses";
    $coursesUpdate = runQuery($query_courseUp);
    $courseID_array = array();
    $updateCourseDataTable = "<tr>";
    while ($courseUpdate = mysqli_fetch_assoc($coursesUpdate)) {
        array_push($courseID_array, $courseUpdate['courseId']);
        $availableSubjects_DD .= "<option>{$courseUpdate['subject']}</option>";
        $updateCourseDataTable .= "<td><input type='text' name='changedSub[]' value='{$courseUpdate['subject']}'></td>";
        $updateCourseDataTable .= "<td><select name='changedTeacher[]'>
                                   <option selected hidden>{$courseUpdate['teacher']}</option>
                                   {$availableTeachers}
                                </select></td>";
        $updateCourseDataTable .= "<td><select name='changedDay[]'>
                                <option selected hidden>{$courseUpdate['classDay']}</option>
                                {$weekDays_DD}
                                </select></td>";
        $updateCourseDataTable .= "<td><input type='time' name='changedTime[]' value='{$courseUpdate['classTime']}'></td>";
        $updateCourseDataTable .= "<td><select name='changedHall[]'>
                                <option selected hidden>{$courseUpdate['hall']}</option>
                                {$availableHalls_DD}
                                </select></td>";
        $updateCourseDataTable .= "</tr>";
    }
//>>>>>>>>>>>>>>Load Data <<<<<<<<<<<<<<<<<<<<<<<<<

//>>>>>>>>>>>>>>Update Data<<<<<<<<<<<<<<<<<<<<<<<<<
    if (isset($_POST['doneUpdate'])) {
        //if($_POST['changesPass'] == $_SESSION['password']) { *************************************** complete this line **************
        if (true) {
            $noOfRows = mysqli_num_rows($coursesUpdate);
            $sub_array = $_POST['changedSub'];
            $tea_array = $_POST['changedTeacher'];
            $day_array = $_POST['changedDay'];
            $time_array = $_POST['changedTime'];
            $hall_array = $_POST['changedHall'];
            for ($i = 0; $i < $noOfRows; $i++) {
                $query_changes = "UPDATE courses SET subject='{$sub_array[$i]}',teacher='{$tea_array[$i]}',classDay='{$day_array[$i]}',classTime ='{$time_array[$i]}' ,hall='{$hall_array[$i]}' WHERE courseID='{$courseID_array[$i]}'";
                runQuery($query_changes);
            }
            echo "<script type='text/javascript'>alert('Course details Successfully Updated !');</script>";
            echo '<script>window.location.href = "owner.php";</script>';
            exit();
        }
    }
//>>>>>>>>>>>>>>Update Data<<<<<<<<<<<<<<<<<<<<<<<<<

//>>>>>>>>>>>>>>Delete Data<<<<<<<<<<<<<<<<<<<<<<<<<

    if (isset($_POST['doneDelete'])) {
        //if($_POST['deletePass'] == $_SESSION['password']) { *************************************** complete this line **************
        if (true) {
            echo "<script type='text/javascript'>alert({$_POST["deleteSub"]});</script>";
            $query_delete = "DELETE FROM courses WHERE subject='{$_POST["deleteSub"]}' AND teacher='{$_POST["deleteTeacher"]}' AND classDay='{$_POST["deleteDay"]}'";
            runQuery($query_delete);
            $deletedRows = mysqli_affected_rows($connection);
            if ($deletedRows == 1) {
                echo "<script type='text/javascript'>alert('Course Successfully Deleted !');</script>";
            } else {
                echo "<script type='text/javascript'>alert('Not found Course match with given data !');</script>";
            }
        } else {
            echo "<script type='text/javascript'>alert('Invalid Password!');</script>";
        }
        echo '<script>window.location.href = "owner.php";</script>';
        exit();
    }

//>>>>>>>>>>>>>>Delete Data<<<<<<<<<<<<<<<<<<<<<<<<<


///////////////////////////////Update Courses////////////////////////////////////////////////////////////

///////////////////////////////Courses////////////////////////////////////////////////////////////

///////////////////////////////Send Notifications////////////////////////////////////////////////////////////
    if (isset($_POST['sendBtn'])) {
        sendNotification("Owner");
        sendNotificationMail("Yureka notification from", $fullName);
        echo "<script type='text/javascript'>alert('Notification Sent!');</script>";
        echo '<script>window.location.href = "owner.php";</script>';
        exit();
    }
///////////////////////////////Send Notifications////////////////////////////////////////////////////////////

///////////////////////////////Change Password////////////////////////////////////////////////////////////
    if (isset($_POST['ochangePassBtn'])) {
        $newPassword = sha1($_POST['onewPass']);
        if ($_SESSION['password'] == sha1($_POST['ocurrentPass'])) {
            $query_cp = "UPDATE owner SET password='{$newPassword}' WHERE indexNumber='{$_SESSION["username"]}'";
            runQuery($query_cp);
            $_SESSION['password'] = $newPassword;
            sendMail($data['email'], "Yureka LogIn Password Changed By", "Your Yureka Institute online user account password changed by " . $fullName . " on " . date("Y-m-d") . " at " . date("h:i:sa") . "<br><br><br><a href='#'>Yureka Higher Education Institute</a> All Rights Reserved!", $fullName);
            echo "<script type='text/javascript'>alert('Password Successfully Changed!');</script>";
        } else {
            echo "<script type='text/javascript'>alert('Invalid Current Password!');</script>";
        }
        echo '<script>window.location.href = "owner.php";</script>';
        exit();
    }
///////////////////////////////Change Password////////////////////////////////////////////////////////////


    /////////////////////////// Add Teacher /////////////////////////////////////////////////////////////////

    $query = "SELECT id FROM teacher ORDER BY id DESC LIMIT 1";
    $result_set = runQuery($query);
    $tIndex = '';
    if ($result_set) {
        $result_set = mysqli_fetch_assoc($result_set);
        $raw = $result_set['id'] + 1;
        $raw = strval($raw);
        $year = substr(strval(date("Y")), -2);
        if (strlen($raw) == 1) {
            $tIndex = $year . "000" . $raw . "T";
        } else if (strlen($raw) == 2) {
            $tIndex = $year . "00" . $raw . "T";
        } else if (strlen($raw) == 3) {
            $tIndex = $year . "0" . $raw . "T";
        } else if (strlen($raw) == 4) {
            $tIndex = $year . $raw . "T";
        } else {
            $tIndex = "SRMI";
        }

    }

    if (isset($_POST['atdone'])) {
        if (sha1($_POST['atPass']) == $_SESSION['password']) {
            $tpass = sha1("teacher123");
            $atquery = "INSERT INTO teacher(indexNumber, firstName, lastName, address, birthDay, gender, email, telephone, eduQualification,profilePic,password) VALUES ('{$_POST["atindex"]}','{$_POST["atfirstName"]}','{$_POST["atlastName"]}','{$_POST["ataddress"]}','{$_POST["atbDay"]}','{$_POST["atgender"]}','{$_POST["atemail"]}','{$_POST["attelephone"]}','{$_POST["ateducationalQualifi"]}','../img/profilePics/16401b92e208d08bd8d0e064441977fc713bf45d.png','{$tpass}')";
            runQuery($atquery);
            sendMail($_POST["atemail"], "Your Registration Index Number of ", $_POST["atfirstName"] . " " . $_POST["atlastName"] . " Welcome to Yureka Institute online System ! <br><br>This is a valid index number issued by Yureka Higner Education Institute.If you have any problem with registration please contact our office. <br><h1 align='center' style='background-color:lightgray; color:#4CAF50; width:400px; padding:20px; border:solid 4px gray; border-radius:50px; margin-left:20%; margin-top: 50px; margin-bottom: 50px;'>Index Number : " . $tIndex . "</h1><br><b>Your Temporary Password is : teacher123</b><br> please change it after your first login.<br><br><a href='#'>Yureka Higher Education Institute</a> All Rights Reserved!", "Yureka Institute");
            echo '<script>alert("Teacher Successfully Added to your System! Teacher Password is : teacher123");</script>';
        } else {
            echo "<script type='text/javascript'>alert('Invalid Password!');</script>";
        }
        echo '<script>window.location.href = "owner.php";</script>';
        exit();
    }


//////////////////////////////////////////////// Add Advertiesment /////////////////////////////
    if (isset($_POST['adddone'])) {
        if (sha1($_POST['addPass']) == $_SESSION['password']) {
            $query_last_id = "SELECT addId FROM advertisements ORDER BY addId DESC LIMIT 1";
            $result_lid = runQuery($query_last_id);
            $result_lid = mysqli_fetch_assoc($result_lid);
            $result_lid = $result_lid['addId'];
            $result_lid = sha1($result_lid);
            $file = $_FILES['addimg'];
            $path_move = "../img/advertiesments/" . $result_lid . ".jpg";
            if (move_uploaded_file($file['tmp_name'], $path_move)) {
                $path_load = "img/advertiesments/" . $result_lid . ".jpg";
                $query_add = "INSERT INTO  advertisements (imagePath , hoverDescription, description,uploadedDate) VALUES ('{$path_load}','{$_POST['addImageDesc']}','{$_POST['addDescription']}',CURDATE())";
                runQuery($query_add);
                echo "<script type='text/javascript'>alert('Successfully Added!');</script>";
            } else {
                echo "<script type='text/javascript'>alert('Failed uploading please try again!');</script>";
            }
        } else {
            echo "<script type='text/javascript'>alert('Invalid Password!');</script>";
        }
        echo '<script>window.location.href = "owner.php";</script>';
        exit();
    }

//////////////////////////////////////////////// Add Advertiesment /////////////////////////////

///////////////////////////////Change Profile pic////////////////////////////////////////////////////////////
    if (isset($_POST['profilepicdone_o'])) {
        if ($data['profilePic'] != '../img/profilePics/16401b92e208d08bd8d0e064441977fc713bf45d.png' && file_exists($data['profilePic'])) {
            unlink($data['profilePic']);
        }
        $pic_id = sha1($data['indexNumber']);
        $file = $_FILES['profileimg_o'];
        $path = "../img/profilePics/" . $pic_id . ".jpg";
        if (move_uploaded_file($file['tmp_name'], $path)) {
            $query_update_pic = "UPDATE owner SET profilePic='{$path}' WHERE indexNumber='{$_SESSION['username']}'";
            runQuery($query_update_pic);
            echo "<script type='text/javascript'>alert('Successfully updated your Profile Picture!');</script>";
        } else {
            echo "<script type='text/javascript'>alert('Failed uploading please try again!');</script>";
        }
        echo '<script>window.location.href = "owner.php";</script>';
        exit();
    }
///////////////////////////////Change Profile pic////////////////////////////////////////////////////////////

    ///////////////////////////////Delete Account////////////////////////////////////////////////////////////
    if(isset($_POST['deleteAccBtn'])){
        $dpass = sha1($_POST['deleteAccPass']);
        if ($_SESSION['password'] ==$dpass ) {
            $query_delete_acc = "DELETE FROM owner WHERE indexNumber='{$_SESSION['username']}' AND password='{$dpass}'";
            runQuery($query_delete_acc);
            echo "<script type='text/javascript'>alert('Successfully Deleted your account!');</script>";
            echo '<script>window.location.href = "login.php";</script>';
            exit();
        }else{
            echo "<script type='text/javascript'>alert('Invalid password!');</script>";
        }

    }
    ///////////////////////////////Delete Account////////////////////////////////////////////////////////////

}
?>

<!--php code here-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Yurekha | Owner</title>
    <link rel="icon" href="../img/favicon.png">
    <link href="../css/main.css" rel="stylesheet">
    <link href="../css/up_in.css" rel="stylesheet">
    <link href="../css/owner.css" rel="stylesheet">

</head>
<body bgcolor="#e3e6ea">
<div class="content">
        <!--header section-->
        <header>
            <center><img src="../img/Yureka%20logo.png" id="mainLogo"></center>
            <!--navigation bar start-->
            <ul class="nav">
                <li><a href="../index.php"><img src="../img/nav/nav_yureka_logo.png"></a></li>
                <li><a href="courses.php" target="_blank">Courses</a></li>
                <li><a href="about.html">About Us</a></li>
<<<<<<< HEAD
<<<<<<< HEAD
                <li><a href="contact.html">Contact Us</a></li>
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
                <li><a href="contact.html">Contact Us</a></li>
=======
                <li><a href="#">Contact Us</a></li>
>>>>>>> d16f7e303373f7aa06afeff3a1c36aeb8d5b1a6a
=======
                <li><a href="#">Contact Us</a></li>
>>>>>>> d16f7e303373f7aa06afeff3a1c36aeb8d5b1a6a
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
=======
<<<<<<< HEAD
                <li><a href="contact.html">Contact Us</a></li>
=======
                <li><a href="#">Contact Us</a></li>
>>>>>>> d16f7e303373f7aa06afeff3a1c36aeb8d5b1a6a
=======
                <li><a href="#">Contact Us</a></li>
>>>>>>> d16f7e303373f7aa06afeff3a1c36aeb8d5b1a6a
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
=======
                <li><a href="#">Contact Us</a></li>
>>>>>>> d16f7e303373f7aa06afeff3a1c36aeb8d5b1a6a
=======
                <li><a href="#">Contact Us</a></li>
>>>>>>> d16f7e303373f7aa06afeff3a1c36aeb8d5b1a6a
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
                </li>
                <li><a href="logout.php"><img src="../img/nav/nav_logout.png" style="vertical-align: bottom">&nbsp;Log
                        Out</a></li>
                <img src='<?php echo $data['profilePic']; ?>' class="profilePic"
                     onclick="document.getElementById('profilePicContainer').style.display='block';">
            </ul>
            <!--navigation bar end-->
        </header>

        <!--body content section-->
        <section>
            <!--Update Profile pic Section-->
            <div id="profilePicContainer" class="modal">
                <div class="modal-content animate">
                    <div class="imgcontainer">
                        <span onclick="document.getElementById('profilePicContainer').style.display='none'"
                              class="close" title="Close Modal">&times;</span>
                    </div>
                    <div class="container">
                        <img src='<?php echo $data['profilePic']; ?>' class="displayProfilepic"><br><br>
                        <label><b>Select New Profile Picture</b></label>
                        <form action="owner.php" method="post" enctype="multipart/form-data">
                            <input type="file" name="profileimg_o"><br>
                            <font size="2" color="red">(*must select square shape images)</font><br>
                            <input type="submit" name="profilepicdone_o" value="Update Profile Picture">
                        </form>
                    </div>
                </div>
            </div>
            <!--Update Profile pic Section-->

            <div class="Containerlayout">
                <div id="left_container">

                    <!--Day Timer and User Info-->
                    <div id="userData">
                        <ul>
                            <li><img src="../img/dayTime/morning.png" class="dayTimeImage">
                                <img src="../img/dayTime/afternoon.png" class="dayTimeImage" style="display: none;">
                                <img src="../img/dayTime/evening.png" class="dayTimeImage" style="display: none;">
                                <img src="../img/dayTime/night.png" class="dayTimeImage" style="display: none;">
                            </li>
                            <ul>
                                <div id="dayTime">Good Evening !</div>
                            </ul>
                        </ul>
                        <a href="#" id="loggedName" class="loggedName" title="Update Information"
                           onclick="ownerLayers(); updateDetails_layer.style.display='block';"><?php echo $fullName; ?></a>
                    </div>
                    <!--Day Timer and User Info-->

                    <div class="vertical-menu">
                        <a href="#" class="active" id="sendNotification"
                           onclick="ownerLayers(); changeLayer(sendNotifi_btn,sendNotifi_layer);">Send Notifications</a>
                        <a href="#" id="advertisement"
                           onclick="ownerLayers(); changeLayer(advertisement_btn,advertisement_layer);">Add
                            Advertisement</a>
                        <a href="#" id="addTeacher"
                           onclick="ownerLayers(); changeLayer(addTeacher_btn,addTeacher_layer);">Add Teacher</a>
                        <a href="#" id="updateCourses"
                           onclick="ownerLayers(); changeLayer(updateCourses_btn,updateCourses_layer);">Manage
                            Courses</a>
                        <a href="#" id="newStudent"
                           onclick="ownerLayers(); changeLayer(newStudent_btn,newStudent_layer);">New Student</a>
                        <a href="#" id="viewStudent"
                           onclick="ownerLayers(); changeLayer(viewStudent_btn,viewStudent_layer);">Search Users</a>
                    </div>
                </div>

                <div id="right_container">


                    <div class="notification_panel" style="display: block;">
                        <form action="owner.php" method="post">
                            <h1 align="center">Send Notifications</h1>
                            <select name="receiver" id="notReceiver">
                                <option>All</option>
                                <option>Students</option>
                                <option>Teachers</option>
                            </select>
                            <textarea rows="10" columns="40" class="message" id="notice" name="notice"
                                      placeholder="Type Your Message Here"></textarea>
                            <ul>
                                <li>
                                    <button class="clr"
                                            onclick="notificationCrear(document.getElementById('notReceiver'),document.getElementById('notice')); return false;">
                                        Clear
                                    </button>
                                </li>
                                <li>
                                    <button class="send" name="sendBtn" id="sendBtn"
                                            onclick="return noticeCheck(document.getElementById('notice'));">Send
                                    </button>
                                </li>
                            </ul>
                        </form>
                    </div>

                    <div class="advertisement_panel" style="display: none;">
                        <form action="owner.php" method="post" enctype="multipart/form-data">
                            <h1 align="center">Add Advertiesments to home page</h1>
                            <textarea rows="10" columns="40" class="message" placeholder="Add Description Here"
                                      name="addDescription" id="addDescription"></textarea>
                            <textarea rows="10" columns="40" class="message"
                                      placeholder="Add Description Here for Image" name="addImageDesc"
                                      id="addImageDesc"></textarea>
                            <input type="file" name="addimg" id="addFileSelect"><br>
                            <font size="2">(*615px X 300px image size recommended)</font><br>
                            <ul>
                                <li>
                                    <button class="clr" onclick="addClrOncilck();">Clear All</button>
                                </li>
                                <li>
                                    <button class="" onclick="addAddOnClick();return false;">Add</button>
                                </li>
                            </ul>

                            <div id="addpasswordSection" class="modal">
                                <div class="modal-content animate">
                                    <div class="imgcontainer">
                                        <span onclick="document.getElementById('addpasswordSection').style.display='none';"
                                              class="close" title="Close Modal">&times;</span>
                                    </div>
                                    <div class="container">
                                        <label><b>Enter Your Password</b></label>
                                        <input type="password" placeholder="Password" name="addPass" required>
                                        <input type="submit" name="adddone" value="Done">
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>

                    <div class="addTeacher_panel" style="display: none;">
                        <div class="formContainer">
                            <form action="owner.php" method="post">
                                <h1 align="center">Add Teacher</h1>
                                <div id="atdatasection">
                                    <Lable>Name</Lable>
                                    <font size="2" class="atwarning" color="red"></font>          <!--name warning 0-->
                                    <br>
                                    <input type="text" id="atfirstName" placeholder="First Name" name="atfirstName">
                                    <input type="text" id="atlastName" placeholder="Last Name" name="atlastName"><br>
                                    <Lable>Address</Lable>
                                    <br>
<<<<<<< HEAD
<<<<<<< HEAD
                                    <textarea rows="4" columns="40" id="ataddress" name="ataddress" placeholder="Address"></textarea>
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
<<<<<<< HEAD
                                    <textarea rows="4" columns="40" id="ataddress" name="ataddress" placeholder="Address"></textarea>
=======
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
                                    <br>
                                    <Lable>Birthday</Lable>
                                    <font size="2" id="BDwarning" color="red"></font>
                                    <br>
                                    <input type="date" id="atbDay" name="atbDay" min="1990-01-01" max="2007-12-31">
=======
=======
>>>>>>> d16f7e303373f7aa06afeff3a1c36aeb8d5b1a6a
                                    <textarea rows="4" columns="40" id="ataddress" name="ataddress"></textarea>
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
                                    <br>
                                    <Lable>Birthday</Lable>
                                    <font size="2" id="BDwarning" color="red"></font>
                                    <br>
<<<<<<< HEAD
                                    <input type="date" id="atbDay" name="atbDay" min="1990-01-01" max="2007-12-31">
=======
                                    <input type="date" id="atbDay" name="atbDay">
<<<<<<< HEAD
>>>>>>> d16f7e303373f7aa06afeff3a1c36aeb8d5b1a6a
=======
>>>>>>> d16f7e303373f7aa06afeff3a1c36aeb8d5b1a6a
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
=======
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
=======
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a

                                    <br>
                                    <Lable>Gender</Lable>
                                    <br>
                                    <select id="atgender" name="atgender">
                                        <option hidden>Select</option>
                                        <option>Male</option>
                                        <option>Female</option>
                                    </select>

                                    <br>
                                    <Lable>Email</Lable>
                                    <font size="2" class="atwarning" color="red"></font>  <!--email warning 1-->
                                    <br>
<<<<<<< HEAD
<<<<<<< HEAD
                                    <input type="email" id="atemail" name="atemail" placeholder="someone@gmail.com">
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
                                    <input type="email" id="atemail" name="atemail" placeholder="someone@gmail.com">
=======
=======
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
                                    <input type="email" id="atemail" name="atemail">
>>>>>>> d16f7e303373f7aa06afeff3a1c36aeb8d5b1a6a
=======
                                    <input type="email" id="atemail" name="atemail">
>>>>>>> d16f7e303373f7aa06afeff3a1c36aeb8d5b1a6a
<<<<<<< HEAD
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
=======
<<<<<<< HEAD
                                    <input type="email" id="atemail" name="atemail" placeholder="someone@gmail.com">
=======
                                    <input type="email" id="atemail" name="atemail">
>>>>>>> d16f7e303373f7aa06afeff3a1c36aeb8d5b1a6a
=======
                                    <input type="email" id="atemail" name="atemail">
>>>>>>> d16f7e303373f7aa06afeff3a1c36aeb8d5b1a6a
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
=======
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a

                                    <br>
                                    <Lable>Telephone</Lable>
                                    <font size="2" class="atwarning">(*Must contain 10 digits)</font><br>
                                    <!--tel warning 2-->
                                    <br>
<<<<<<< HEAD
<<<<<<< HEAD
                                    <input type="tel" id="attelephoneNo" name="attelephone" placeholder="07xxxxxxxx">
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
                                    <input type="tel" id="attelephoneNo" name="attelephone" placeholder="07xxxxxxxx">
=======
                                    <input type="tel" id="attelephoneNo" name="attelephone">
>>>>>>> d16f7e303373f7aa06afeff3a1c36aeb8d5b1a6a
=======
                                    <input type="tel" id="attelephoneNo" name="attelephone">
>>>>>>> d16f7e303373f7aa06afeff3a1c36aeb8d5b1a6a
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
=======
<<<<<<< HEAD
                                    <input type="tel" id="attelephoneNo" name="attelephone" placeholder="07xxxxxxxx">
=======
=======
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
                                    <input type="tel" id="attelephoneNo" name="attelephone">
>>>>>>> d16f7e303373f7aa06afeff3a1c36aeb8d5b1a6a
=======
                                    <input type="tel" id="attelephoneNo" name="attelephone">
>>>>>>> d16f7e303373f7aa06afeff3a1c36aeb8d5b1a6a
<<<<<<< HEAD
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
=======
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a

                                    <br>
                                    <Lable>Educational Qualifications</Lable>
                                    <br>
<<<<<<< HEAD
<<<<<<< HEAD
                                    <input type="text" id="ateduQualifications" name="ateducationalQualifi" placeholder="Bsc(Eng)">
=======
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
<<<<<<< HEAD
                                    <input type="text" id="ateduQualifications" name="ateducationalQualifi" placeholder="Bsc(Eng)">
=======
=======
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
                                    <input type="text" id="ateduQualifications" name="ateducationalQualifi">
>>>>>>> d16f7e303373f7aa06afeff3a1c36aeb8d5b1a6a
=======
                                    <input type="text" id="ateduQualifications" name="ateducationalQualifi">
>>>>>>> d16f7e303373f7aa06afeff3a1c36aeb8d5b1a6a
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
=======
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
=======
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a


                                    <button onclick="atValidationOnclick(); return false;">Add Teacher</button>
                                </div>

                                <dev id="atindex" style="display: none;">
                                    <input type="text" name="atindex"
                                           id="atdisplayIndex" <?php echo "value='{$tIndex}'"; ?> readonly>
                                    <input type="submit" id="atissuedIndex" name="atissue"
                                           value="Comlepete Registration"
                                           onclick="document.getElementById('atpasswordSection').style.display='block';return false;">
                                </dev>

                                <div id="atpasswordSection" class="modal">
                                    <div class="modal-content animate">
                                        <div class="imgcontainer">
                                            <span onclick="document.getElementById('atpasswordSection').style.display='none';"
                                                  class="close" title="Close Modal">&times;</span>
                                        </div>
                                        <div class="container">
                                            <label><b>Enter Your Password</b></label>
                                            <input type="password" placeholder="Password" name="atPass" required>
                                            <input type="submit" name="atdone" value="Done">
                                        </div>
                                    </div>
                                </div>
                                <!---->
                            </form>
                        </div>
                    </div>

                    <div class="updateCourses_panel" style="display: none;">
                        <!-- >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>inner Links<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<-->
                        <a href="#update_section">Update Course</a>&nbsp;&nbsp;&nbsp;&nbsp;<a
                                href="#deleteCourse_innerLink">Delete Course</a>
                        <!-- >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>inner Links<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<-->

                        <!-- >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>Add courses section<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<-->
                        <div class="formContainer" id="addCourse_innerLink">
                            <form action="owner.php" method="post">
                                <h1 align="center">Add New Course</h1>
                                <label>Subject</label><br>
                                <input type="text" placeholder="Subject" name="subject" id="subject">
                                <label>Teacher</label><br>
                                <select name="teacher" title="Only display registered teachers" id="teacherSelect">
                                    <option selected hidden>Select Teacher</option>
                                    <?php
                                    echo $availableTeachers;
                                    ?>
                                </select>
                                <br>
                                <label>Class Day</label><br>
                                <select name="classDay">
                                    <?php
                                    echo $weekDays_DD;
                                    ?>
                                </select>
                                <br>
                                <label>Time</label><br>
                                <input type="time" name="classTime" id="classTime" value="06:00">
                                <br>
                                <label>Hall</label><br>
                                <select name="hall">
                                    <?php
                                    echo $availableHalls_DD;
                                    ?>
                                </select>
                                <br>

                                <input type="submit" value="Add Course" onclick="addCourseOnClick()">

                                <!--Index container -->
                                <div id="validateAddCourse" class="modal">
                                    <div class="modal-content animate">
                                        <div class="imgcontainer">
                                            <span onclick="document.getElementById('validateAddCourse').style.display='none'"
                                                  class="close" title="Close Modal">&times;</span>
                                        </div>
                                        <div class="container">
                                            <label><b>Enter Password</b></label>
                                            <input type="password" placeholder="Password" name="upPass" required>
                                            <input type="submit" name="doneAdd" value="Done">
                                        </div>
                                    </div>
                                </div>
                                <!---->
                            </form>
                        </div>
                        <br>

                        <!-- >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>Add courses section<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<-->

                        <hr class="hr1">
                        <hr class="hr1">

                        <!-- >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>update courses section<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<-->
                        <div id="update_section">
                            <form action="owner.php" method="post">
                                <h1 align="center">Update Course</h1>
                                <table>
                                    <tr>
                                        <th>Subject</th>
                                        <th>Teacher</th>
                                        <th>Class Day</th>
                                        <th>Time</th>
                                        <th>Hall</th>
                                    </tr>

                                    <?php echo $updateCourseDataTable; ?>

                                </table>
                                <input type="submit" name="updateCourses" value="Update Changes"
                                       onclick="document.getElementById('changeCourse').style.display = 'block';">
                                <!--Password for course changes -->
                                <div id="changeCourse" class="modal">
                                    <div class="modal-content animate">
                                        <div class="imgcontainer">
                                            <span onclick="document.getElementById('changeCourse').style.display='none'"
                                                  class="close" title="Close Modal">&times;</span>
                                        </div>
                                        <div class="container">
                                            <label><b>Enter Password</b></label>
                                            <input type="password" placeholder="Password" name="changesPass" required>
                                            <input type="submit" name="doneUpdate" value="Save Changes">
                                        </div>
                                    </div>
                                </div>
                                <!--Password for course changes-->

                            </form>

                        </div>
                        <!-- >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>update courses section<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<-->

                        <hr class="hr1" style="margin-top: 50px;">
                        <hr class="hr1" style="margin-bottom: 50px;">

                        <!-- >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>Delete courses section<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<-->
                        <div id="deleteCourse_innerLink">
                            <form action="owner.php" method="post" id="deleteBorder">
                                <h1 align="center" style="color: red;">Delete Course</h1>
                                <h6 align="center" style="font-weight: normal;"><font size="2">(*must fill all fields to
                                        delete)</font></h6>
                                <ul style="margin-left: 12%;">

                                    <li><select name="deleteSub" id="deleteSub">
                                            <option selected hidden>Select Subject</option>
                                            <?php echo $availableSubjects_DD; ?>
                                        </select></li>
                                    <li><select name="deleteTeacher" id="deleteTeacher">
                                            <option selected hidden>Select Teacher</option>
                                            <?php echo $availableTeachers; ?>
                                        </select></li>
                                    <li><select name="deleteDay" id="deleteDay">
                                            <option selected hidden>Select Day</option>
                                            <?php echo $weekDays_DD; ?>
                                        </select></li>
                                    <li><input type="submit" id="deleteBtn" value="Delete Subject"
                                               onclick="deleteOnClick();"></li>
                                </ul>
                                <!--Password for delete courses -->
                                <div id="deleteCourse" class="modal">
                                    <div class="modal-content animate">
                                        <div class="imgcontainer">
                                            <span onclick="document.getElementById('deleteCourse').style.display='none'"
                                                  class="close" title="Close Modal">&times;</span>
                                        </div>
                                        <div class="container">
                                            <label><b>Enter Password</b></label>
                                            <input type="password" placeholder="Password" name="deletePass" required>
                                            <input type="submit" name="doneDelete" value="Done">
                                        </div>
                                    </div>
                                </div>
                                <!--Password for delete courses -->

                            </form>
                        </div>

                        <!-- >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>Delete courses section<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<-->
                        <!-- >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>inner Links<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<-->
                        <a href="#right_container">Add New Course</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#update_section">Update
                            Course</a>
                        <!-- >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>inner Links<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<-->
                    </div>

                    <div class="updateDetails_panel" style="display:none;">
                        <div class="formContainer">
                            <form id="oupdateDetails" action="" method="post">
                                <h1 align="center">Update Details</h1>
                                <br>
                                <Lable>Index Number</Lable>
                                <br>
                                <input type="text"
                                    <?php echo "value='{$data["indexNumber"]}'"; ?> disabled>
                                <Lable>Name</Lable>
                                <font size="2" class="warning" color="red"></font>          <!--name warning 0-->
                                <br>
                                <input type="text" id="ofirstName" placeholder="First Name"
                                       name="ofirstName" <?php echo "value='{$data["firstName"]}'"; ?>>
                                <input type="text" id="olastName" placeholder="Last Name"
                                       name="olastName" <?php echo "value='{$data["lastName"]}'"; ?>><br>


                                <br>
                                <Lable>Address</Lable>
                                <br>
                                <textarea rows="4" columns="40" id="oaddress"
                                          name="oaddress"><?php echo $data["address"]; ?></textarea>
                                <br>
                                <Lable>Birthday</Lable>
                                <br>
<<<<<<< HEAD
<<<<<<< HEAD
                                <input type="date" id="obDay" name="obday" <?php echo "value='{$data["birthDay"]}'"; ?> min="1990-01-01" max="2007-12-31">
=======
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
<<<<<<< HEAD
                                <input type="date" id="obDay" name="obday" <?php echo "value='{$data["birthDay"]}'"; ?> min="1990-01-01" max="2007-12-31">
=======
=======
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
                                <input type="date" id="obDay" name="obday" <?php echo "value='{$data["birthDay"]}'"; ?>>
>>>>>>> d16f7e303373f7aa06afeff3a1c36aeb8d5b1a6a
=======
                                <input type="date" id="obDay" name="obday" <?php echo "value='{$data["birthDay"]}'"; ?>>
>>>>>>> d16f7e303373f7aa06afeff3a1c36aeb8d5b1a6a
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
=======
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
=======
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a

                                <br>
                                <Lable>Gender</Lable>
                                <br>
                                <select id="ogender" name="ogender">
                                    <option hidden>Select</option>
                                    <option <?php if ($data["gender"] == "Male") {
                                        echo "selected='selected'";
                                    } ?>>Male
                                    </option>
                                    <option <?php if ($data["gender"] == "Female") {
                                        echo "selected='selected'";
                                    } ?>>Female
                                    </option>
                                </select>

                                <br>
                                <Lable>Email</Lable>
                                <font size="2" class="warning" color="red"></font>  <!--email warning 1-->
                                <br>
                                <input type="email" id="oemail" name="oemail" <?php echo "value='{$data["email"]}'"; ?>>

                                <br>
                                <Lable>Telephone</Lable>
                                <font size="2" class="warning">(*Must contain 10 digits)</font><br> <!--tel warning 2-->
                                <font size="2" class="warning" color="red"></font><br> <!--tel warning 3-->
                                <input type="tel" id="otelephoneNo"
                                       name="otelephone" <?php echo "value='{$data["telephone"]}'"; ?>>

                                <br>
                                <input type="submit" value="Update" onclick="updateValidationOnclick();">
                                <!--onclick="submitOnclick();" for validations"-->

                                <!--Index container -->
                                <div id="id01" class="modal">
                                    <div class="modal-content animate">
                                        <div class="imgcontainer">
                                            <span onclick="document.getElementById('id01').style.display='none'"
                                                  class="close" title="Close Modal">&times;</span>
                                        </div>
                                        <div class="container">
                                            <label><b>Enter Your Password</b></label>
                                            <input type="password" placeholder="Password" name="updatePass" required>
                                            <input type="submit" name="saveChanges" value="Save Changes">
                                        </div>
                                    </div>
                                </div>
                                <!---->
                                <a href="#"
                                   onclick="document.getElementById('changePassword').style.display='block';return false;">Change
                                    Password</a>
                                <a href="#" class="deleteAccount"
                                   onclick="document.getElementById('deleteAccPass').style.display='block';return false;">Delete My Account</a>

                            </form>

                            <form action="owner.php" method="post">
                                <!--change password container -->
                                <div id="changePassword" class="modal">
                                    <div class="modal-content animate">
                                        <div class="imgcontainer">
                                            <span onclick="document.getElementById('changePassword').style.display='none'"
                                                  class="close" title="Close Modal">&times;</span>
                                        </div>
                                        <div class="container">
                                            <label><b>Change Password</b></label>
                                            <input type="password" placeholder="Current Password" name="ocurrentPass"
                                                   id="ocurrentPass" required>
                                            <font size="2" id="ochangePassWarn">(*password must have 8-16 digits)</font><br>
                                            <input type="password" placeholder="New Password" name="onewPass"
                                                   id="onewPass" required>
                                            <input type="password" placeholder="Confirm New Password" name="ocmfnewPass"
                                                   id="ocmfPass" required>
                                            <input type="submit" name="ochangePassBtn" value="Change Password"
                                                   onclick="return changePassBtnOnclick(document.getElementById('ocurrentPass'),document.getElementById('onewPass'),document.getElementById('ocmfPass'),document.getElementById('ochangePassWarn'));">
                                        </div>
                                    </div>
                                </div>
                                <!---->
                            </form>

                            <!--Delete Account-->
                            <form action="owner.php" method="post">
                                <!--Password container -->
                                <div id="deleteAccPass" class="modal">
                                    <div class="modal-content animate">
                                        <div class="imgcontainer" ">
                                        <span onclick="document.getElementById('deleteAccPass').style.display='none'"
                                              class="close" title="Close Modal">&times;</span>
                                    </div>
                                    <div class="container">
                                        <label><b>Are you sure about this decision ?</b></label>
                                        <input type="password" placeholder="Password" name="deleteAccPass" class="resetFields" required>
                                        <input type="submit" name="deleteAccBtn" value="Delete Account" >
                                    </div>
                                </div>
                        </div>
                        <!---->
                        </form>
                        <!--Delete Account-->

                        </div>

                    </div>

                    <div class="newStudent_panel" style="display: none;">
                        <h1 align="center">Register New Student</h1>
                        <button id="generateIndex">Generate Index</button>
                        <form method="post" action="owner.php" style="display: none;" id="indexForm">
                            <input type="text" name="index" id="displayIndex" readonly>
<<<<<<< HEAD
<<<<<<< HEAD
                            <input type="text" placeholder="someone@gmail.com (optional)"
=======
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
<<<<<<< HEAD
                            <input type="text" placeholder="someone@gmail.com (optional)"
=======
=======
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
                            <input type="text" placeholder="Student Email Here (optional)"
>>>>>>> d16f7e303373f7aa06afeff3a1c36aeb8d5b1a6a
=======
                            <input type="text" placeholder="Student Email Here (optional)"
>>>>>>> d16f7e303373f7aa06afeff3a1c36aeb8d5b1a6a
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
=======
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
=======
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
                                   title="Add student have an email" name="stumail" id="stumail">
                            <input type="submit" id="issuedIndex" name="issue" value="Issued">
                        </form>

                    </div>

                <div class="view_table" style="display: none;">
                    <h1 align="center">Search Students</h1>
                    <div class="formContainer" id="searchContainer">
                    <form method="post" class="searchContainer">
                        <input type="search" id="index" name="index"  placeholder="Search Index" required>
                        <button  onclick="getData(document.getElementById('index').value,'searchResults'); return false;" class="searchBtn">Search</button>
                    </form>
                    </div>
                    <div id="searchResults">
                    </div>
                </div>
                </div>
            </div>

        </section>
        <!--footer section-->
        <footer>
            <hr class="hr1">
            <hr class="hr2">
            <p align="center" style="font-size: small;" title="Yureka Higher Education Institute"><a
                        href="../index.php">Yureka Higher Education Institute</a> All Rights Reserved.</p>
        </footer>
    </div>

<script>
    var generate_btn = document.getElementById("generateIndex");
    var display = document.getElementById("displayIndex");
    var issuedBtn = document.getElementById("issuedIndex");
    var formLayer = document.getElementById("indexForm");

    var index = '<?php $indexNo = indexGenerate();
        echo $indexNo?>';

    generate_btn.onclick = function () {
        display.value = index;
        generate_btn.style.display = "none";
        formLayer.style.display = "block";
    }

    issuedBtn.onclick = function () {
        alert(index + " Index Successfully Issued!");
        formLayer.style.display = "none";
        generate_btn.style.display = "block";
    }


</script>

<script src="../javascript/jquery/jquery-3.2.1.min.js"></script>
<script src="../javascript/validations/ownerValidations.js"></script>
<script src="../javascript/validations/Validations.js"></script>
<script src="../javascript/dayTimeSelector.js"></script>
<script src="../javascript/Layers.js"></script>
<script type="text/javascript">
    function getData(empid, divid) {
        if (empid.length >0) {
            $.ajax({
                url: 'searchResults.php?empid=' + empid, //call storeemdata.php to store form data
                success: function (html) {
                    var ajaxDisplay = document.getElementById(divid);
                    ajaxDisplay.innerHTML = html;
                }
            });
        }else{
            alert("You must enter index before search!");
        }
    }
</script>

<?php
///////update details code//////////////////////////////////////////////////////////////////////////////////////////
function updateData()
{
    global $data;
    $firstName = $_POST['ofirstName'];
    $lastName = $_POST['olastName'];
    $address = $_POST['oaddress'];
    $bday = $_POST['obday'];
    $gender = $_POST['ogender'];
    $email = $_POST['oemail'];
    $telephone = $_POST['otelephone'];

    $checkChanges = $firstName != $data['firstName'] || $lastName != $data['lastName'] || $address != $data['address'] || $bday != $data['birthDay']
        || $gender != $data['gender'] || $email != $data['email'] || $telephone != $data['telephone'];

    $query = "UPDATE owner SET firstName='$firstName',lastName='$lastName',address='$address',birthDay='$bday',gender='$gender',email='$email',telephone='$telephone' WHERE indexNumber='{$_SESSION["username"]}' AND password='{$_SESSION["password"]}'";
    if ($checkChanges) {
        if (sha1($_POST['updatePass']) == $_SESSION['password']) {
            runQuery($query);
            echo "<script>alert('Successfully updated!');</script>";
            echo "<script>window.location.href = 'owner.php';</script>";
        } else {
            echo "<script>alert('Invalid Password!'); updateDetails_layer.style.display = 'block';</script>";
        }
    } else {
        echo "<script>alert('No changes detected!'); updateDetails_layer.style.display = 'block';</script>";

    }
}

if ($_SESSION['logged']) {
    if (isset($_POST['saveChanges'])) {
        updateData();
    }
}

///////update details code//////////////////////////////////////////////////////////////////////////////////////////

?>

</body>
</html>
