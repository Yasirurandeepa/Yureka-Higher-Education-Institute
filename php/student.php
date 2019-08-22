<?php
require("connection/dbConnection.php");
require("notifications/notifications.php");
///////Load user data//////////////////////////////////////////////////////////////////////////////////////////
session_start();
$query = "SELECT * FROM student WHERE indexNumber='{$_SESSION["username"]}' AND password='{$_SESSION["password"]}'";
$result = runQuery($query);
if (mysqli_num_rows($result) == 1 && $_SESSION['logged']) {
    $data = mysqli_fetch_assoc($result);
    $fullName = $data['firstName'] . " " . $data['lastName'];

///////Load user data//////////////////////////////////////////////////////////////////////////////////////////

    ///////Load available results//////////////////////////////////////////////////////////////////////////////////////////
    $query_modules = "SELECT subject FROM courses";
    $moduleResult = runQuery($query_modules);
    $result_panel="";
    while ($subject_r = mysqli_fetch_assoc($moduleResult)){
        $query_results = "SELECT * FROM results WHERE indexNumber='{$_SESSION["username"]}' AND subject='{$subject_r['subject']}'";
        $result_data = runQuery($query_results);
        $result_data = mysqli_fetch_assoc($result_data);
        $result_sub="";
        if(sizeof($result_data)>0) {
            $result_sub.='<h1 align="center">Your Result for '.$subject_r['subject'].'</h1>';
            $result_sub .= '<table>
                             <tr>
                                <td>Subject</td>
                                <td>' . $result_data['subject'] . '</td>
                            </tr>
                            <tr>
                                <td>Marks</td>';
            if (strlen($result_data['marks']) > 3) {
                $result_sub .= '<td>' . $result_data['marks'] . '</td>';
            } else {
                $result_sub .= '<td>' . $result_data['marks'] . '%</td>';
            };
            $result_sub .= '</tr>
                        </table>';
        }
        $result_panel= $result_sub.$result_panel;
    }

///////Load available results//////////////////////////////////////////////////////////////////////////////////////////

///////Load available Notifications////////////////////////////////////////////////////////////////////////////////

    $notificationPanel = loadNotifiPanel(loadData('Students'));

///////Load available Notifications////////////////////////////////////////////////////////////////////////////////

    /////////////////////////////////Change Password////////////////////////////////////////////////////////////
    if (isset($_POST['schangePassBtn'])) {
        $newPassword = sha1($_POST['snewPass']);
        if ($_SESSION['password'] == sha1($_POST['scurrentPass'])) {
            $query_cp = "UPDATE student SET password='{$newPassword}' WHERE indexNumber='{$_SESSION["username"]}'";
            runQuery($query_cp);
            $_SESSION['password'] = $newPassword;
            sendMail($data['email'], "Yureka LogIn Password Changed By", "Your Yureka Institute online user account password changed by " . $fullName . " on " . date("Y-m-d") . " at " . date("h:i:sa") . "<br><br><br><a href='#'>Yureka Higher Education Institute</a> All Rights Reserved!", $fullName);
            echo "<script type='text/javascript'>alert('Password Successfully Changed!');</script>";
        } else {
            echo "<script type='text/javascript'>alert('Invalid Current Password!');</script>";
        }
        echo '<script>window.location.href = "student.php";</script>';
        exit();
    }
///////////////////////////////Change Password////////////////////////////////////////////////////////////

    ///////////////////////////////Change Profile pic////////////////////////////////////////////////////////////
    if (isset($_POST['profilepicdone_s'])) {
        if ($data['profilePic'] != '../img/profilePics/16401b92e208d08bd8d0e064441977fc713bf45d.png' && file_exists($data['profilePic'])) {
            unlink($data['profilePic']);
        }
        $pic_id = sha1($data['indexNumber']);
        $file = $_FILES['profileimg_s'];
        $path = "../img/profilePics/" . $pic_id . ".jpg";
        if (move_uploaded_file($file['tmp_name'], $path)) {
            $query_update_pic = "UPDATE student SET profilePic='{$path}' WHERE indexNumber='{$_SESSION['username']}'";
            runQuery($query_update_pic);
            echo "<script type='text/javascript'>alert('Successfully updated your Profile Picture!');</script>";
        } else {
            echo "<script type='text/javascript'>alert('Failed uploading please try again!');</script>";
        }
        echo '<script>window.location.href = "student.php";</script>';
        exit();
    }
    ///////////////////////////////Change Profile pic////////////////////////////////////////////////////////////

    ///////////////////////////////load Tutorials////////////////////////////////////////////////////////////
    $query_modules = "SELECT subject FROM courses";
    $moduleResult = runQuery($query_modules);
    $tutorial_panel = '';
    $query_tu = "SELECT * FROM tutorials";
    $i = 0;
    while ($module = mysqli_fetch_assoc($moduleResult)) {
        $tutorialResult = runQuery($query_tu);
        $subject = $module['subject'];
        $tutorial_panel .= '<div class="tmodule"><h2 class="tmoduleName" onclick="tmoduleOnclick(' . $i . ');">&#9672; ' . $subject . ' tutorials </h2><div class="tutoContainer">';
        $moduleEmptyCheck = true;
        while ($tuData = mysqli_fetch_assoc($tutorialResult)) {
            $tsubject = $tuData['subject'];
            $tuName = $tuData['tutorialName'];
            $tuPath = $tuData['filePath'];
            $tuLink = $tuData['link'];
            $tuTeacher = $tuData['teacher'];
            $tuUpDate = $tuData['uploadedDate'];
            $tuMsg = $tuData['tutorialMsg'];
            $fileType = '../img/fileTypes/';
            $fileTypeName = "";
            switch (substr($tuPath, -4)) {
                case '.pdf':
                    $fileType .= 'pdf.png';
                    $fileTypeName = "PDF File";
                    break;
                case 'docx':
                    $fileType .= 'word.png';
                    $fileTypeName = "Word File";
                    break;
                case 'xlsx':
                    $fileType .= 'excel.png';
                    $fileTypeName = "Excel File";
                    break;
                case '.png':
                    $fileType .= 'image.png';
                    $fileTypeName = "Image File";
                    break;
                case '.jpg':
                    $fileType .= 'image.png';
                    $fileTypeName = "Image File";
                    break;
                case '.ppt':
                    $fileType .= 'ppt.png';
                    $fileTypeName = "PPT File";
                    break;
                case 'pptx':
                    $fileType .= 'ppt.png';
                    $fileTypeName = "PPTX File";
                    break;
                case '.txt':
                    $fileType .= 'txt.png';
                    $fileTypeName = "Text File";
                    break;
                case '.mp4':
                    $fileType .= 'video.png';
                    $fileTypeName = "Video File";
                    break;
                case '.zip':
                    $fileType .= 'zip.png';
                    $fileTypeName = "Zip File";
                    break;
                case '.rar':
                    $fileType .= 'zip.png';
                    $fileTypeName = "RAR File";
                    break;
                default:
                    $fileType .= 'default.png';
                    $fileTypeName = "File";
                    break;
            }
            if ($subject == $tsubject) {
                $moduleEmptyCheck = false;
                $tutorial_panel .= '<div class="tutorial" title="'.$tuMsg.'">
                                    <label class="tutoName"><b>' . $tuName . '</b></label><br>';

                if (strlen(trim($tuPath)) > 0) {
                    $tutorial_panel .= '<a href="' . $tuPath . '" class="tutoLink"><img class="fileType" style="margin-left:31px;margin-top:5px;" src="' . $fileType . '"><br>Download ' . $fileTypeName . ' Here</a><span style="width:40px;display:table-cell;"></span>';
                }
                if (strlen(trim($tuLink)) > 0) {
                    $tutorial_panel .= '<a href="' . $tuLink . '" class="tutoLink" target="_blank""><img class="fileType" style="margin-left:22px;margin-top:5px;" src="../img/fileTypes/url.png"><br>Goto Link Here</a>';
                }

                $tutorial_panel .= '<br><label class="uploadedBy">Uploaded by ' . $tuTeacher . ' On ' . $tuUpDate . '</label>
                                </div>';
            }
        }
        if($moduleEmptyCheck){
            $tutorial_panel.="<label>No Tutorials available</label>";
        }
        $tutorial_panel .= '</div></div>';
        $i++;
    }


    ///////////////////////////////Load Tutorials////////////////////////////////////////////////////////////

    ///////////////////////////////Delete Account////////////////////////////////////////////////////////////
    if(isset($_POST['deleteAccBtn'])){
        $dpass = sha1($_POST['deleteAccPass']);
        if ($_SESSION['password'] ==$dpass ) {
            $query_delete_acc = "DELETE FROM student WHERE indexNumber='{$_SESSION['username']}' AND password='{$dpass}'";
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Yurekha | Student</title>
    <link rel="icon" href="../img/favicon.png">
    <link href="../css/main.css" rel="stylesheet">
    <link href="../css/up_in.css" rel="stylesheet">
    <link href="../css/courses.css" rel="stylesheet">
    <link href="../css/owner.css" rel="stylesheet">
    <link href="../css/student.css" rel="stylesheet">
    <link href="../css/notification_panel.css" rel="stylesheet">
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
                <li id="nav_noti"><a href="#" onclick="openNav()" style="color: white;"><img
                                src='<?php echo $notifiLogo; ?>'></a></li>
                <li><a href="logout.php"><img src="../img/nav/nav_logout.png" style="vertical-align: bottom">&nbsp;Log
                        Out</a></li>
                <img src='<?php echo $data['profilePic']; ?>' class="profilePic"
                     onclick="document.getElementById('profilePicContainer').style.display='block'">
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
                        <form action="student.php" method="post" enctype="multipart/form-data">
                            <input type="file" name="profileimg_s"><br>
                            <font size="2" color="red">(*must select square shape images)</font><br>
                            <input type="submit" name="profilepicdone_s" value="Update Profile Picture">
                        </form>
                    </div>
                </div>
            </div>
            <!--Update Profile pic Section-->

            <!--Notification panel-->
            <div id="myNav" class="overlay">
                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                <a id="topic">Notification Panel</a>
                <hr class="hr1">
                <hr class="hr2">
                <div class="overlay-content">
                    <?php
                    echo $notificationPanel;
                    ?>
                </div>
            </div>
            <!--Notification panel-->

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
                                <div id="dayTime">Good Evening!</div>
                            </ul>
                        </ul>
                        <a href="#" id="loggedName" class="loggedName" title="Update Information"
                           onclick="studentLayers(); updateDetails_layer.style.display='block';"><?php echo $fullName; ?></a>
                    </div>
                    <!--Day Timer and User Info-->

                    <div class="vertical-menu">
                        <a href="#" class="active" id="tutorials"
                           onclick="studentLayers(); changeLayer(tutorials_btn,tutorials_layer);">Tutorials</a>
                        <a href="#" id="results" onclick="studentLayers(); changeLayer(results_btn,results_layer);">Results</a>
                    </div>
                </div>
                <div id="right_container">
                    <div class="tutorial_panel" style="display: block;">
                        <h1 align="center">Tutorials</h1>
                        <?php
                        echo $tutorial_panel;
                        ?>
                    </div>

                    <div class="results_panel" style="display: none;">
                        <?php echo $result_panel;?>
                        </div>

                    <div class="updateDetails_panel" style="display:none;">
                        <div class="formContainer">
                            <form id="supdateDetails" action="student.php" method="post">
                                <h1 align="center">Update Details</h1><br>
                                <Lable>Index Number</Lable>
                                <br>
                                <input type="text"
                                    <?php echo "value='{$data["indexNumber"]}'"; ?> disabled>

                                <Lable>Name</Lable>
                                <font size="2" class="warning" color="red"></font>          <!--name warning 0-->
                                <br>
                                <input type="text" id="sfirstName" placeholder="First Name"
                                       name="sfirstName" <?php echo "value='{$data["firstName"]}'"; ?>>
                                <input type="text" id="slastName" placeholder="Last Name"
                                       name="slastName" <?php echo "value='{$data["lastName"]}'"; ?>><br>


                                <br>
                                <Lable>Address</Lable>
                                <br>
                                <textarea rows="4" columns="40" id="saddress"
                                          name="saddress"><?php echo $data["address"]; ?></textarea>
                                <br>
                                <Lable>Birthday</Lable>
                                <br>
                                <input type="date" id="sbDay" name="sbday" <?php echo "value='{$data["birthDay"]}'"; ?>>

                                <br>
                                <Lable>Gender</Lable>
                                <br>
                                <select id="sgender" name="sgender">
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
                                <input type="email" id="semail" name="semail" <?php echo "value='{$data["email"]}'"; ?>>

                                <br>
                                <Lable>Telephone</Lable>
                                <font size="2" class="warning">(*Must contain 10 digits)</font><br> <!--tel warning 2-->
                                <font size="2" class="warning" color="red"></font><br> <!--tel warning 3-->
                                <input type="tel" id="stelephoneNo"
                                       name="stelephone" <?php echo "value='{$data["telephone"]}'"; ?>>

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

                            <form action="student.php" method="post">
                                <!--change password container -->
                                <div id="changePassword" class="modal">
                                    <div class="modal-content animate">
                                        <div class="imgcontainer">
                                            <span onclick="document.getElementById('changePassword').style.display='none'"
                                                  class="close" title="Close Modal">&times;</span>
                                        </div>
                                        <div class="container">
                                            <label><b>Change Password</b></label>
                                            <input type="password" placeholder="Current Password" name="scurrentPass"
                                                   id="ocurrentPass" required>
                                            <font size="2" id="ochangePassWarn">(*password must have 8-16 digits)</font><br>
                                            <input type="password" placeholder="New Password" name="snewPass"
                                                   id="onewPass" required>
                                            <input type="password" placeholder="Confirm New Password" name="scmfnewPass"
                                                   id="ocmfPass" required>
                                            <input type="submit" name="schangePassBtn" value="Change Password"
                                                   onclick="return changePassBtnOnclick(document.getElementById('ocurrentPass'),document.getElementById('onewPass'),document.getElementById('ocmfPass'),document.getElementById('ochangePassWarn'));">
                                        </div>
                                    </div>
                                </div>
                                <!---->
                            </form>
                            <!--Delete Account-->
                            <form action="student.php" method="post">
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

<script src="../javascript/dayTimeSelector.js"></script>
<script src="../javascript/notificationPanel.js"></script>
<script src="../javascript/Layers.js"></script>
<script src="../javascript/validations/studentValidations.js"></script>
<script src="../javascript/validations/Validations.js"></script>
<?php
///////update details code//////////////////////////////////////////////////////////////////////////////////////////
function updateData()
{
    global $data;
    $firstName = $_POST['sfirstName'];
    $lastName = $_POST['slastName'];
    $address = $_POST['saddress'];
    $bday = $_POST['sbday'];
    $gender = $_POST['sgender'];
    $email = $_POST['semail'];
    $telephone = $_POST['stelephone'];

    $checkChanges = $firstName != $data['firstName'] || $lastName != $data['lastName'] || $address != $data['address'] || $bday != $data['birthDay']
        || $gender != $data['gender'] || $email != $data['email'] || $telephone != $data['telephone'];

    $query = "UPDATE student SET firstName='$firstName',lastName='$lastName',address='$address',birthDay='$bday',gender='$gender',email='$email',telephone='$telephone' WHERE indexNumber='{$_SESSION["username"]}' AND password='{$_SESSION["password"]}'";
    if ($checkChanges) {
        if (sha1($_POST['updatePass']) == $_SESSION['password']) {
            runQuery($query);
            echo "<script>alert('Successfully updated!');</script>";
            echo "<script>window.location.href = 'student.php';</script>";
        } else {
            echo "<script>alert('Invalid Password!'); updateDetails_layer.style.display = 'block';</script>";
        }
    } else {
        echo "<script>alert('No changes detected!'); updateDetails_layer.style.display = 'block';</script>";

    }
}

if ($_SESSION['logged']) {
    if (isset($_POST['updatePass'])) {
        updateData();
    }
}

///////update details code//////////////////////////////////////////////////////////////////////////////////////////


?>
</body>
</html>