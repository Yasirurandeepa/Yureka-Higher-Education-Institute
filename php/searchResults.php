<!DOCTYPE html>
<html>
<head>
    <link href="../css/main.css" rel="stylesheet">
    <link href="../css/up_in.css" rel="stylesheet">
    <style>
        .searchResult{
            background-color: rgba(145, 145, 145,0.5);
            padding: 5% 8%;
            border-radius: 50px;
            margin: auto;
            width: 60%;
            height: auto;
            margin-bottom: 40px;
        }

        .resultImage{
            width:160px;
            height: 160px;
            border-radius: 50%;
            border: solid 5px white;
            margin: auto 35%;
            transition: transform 0.5s ease;
        }

        #searchedData{
            text-align: center;
            line-height: 1.5;
            font-size: large;
            transition: transform 0.5s ease;

        }

        a:hover{
            color: white;
        }

        .resultImage:hover{
            transform: scale(1.5);
        }

        #searchedData:hover{
            transform: scale(1.2);
        }
    </style>
</head>
<body>
<?php
require("connection/dbConnection.php");
$empid = $_GET['empid'];
$empIDLastLetter = strtoupper(substr($empid, -1));
$teacherCheck = false;
$teacher = false;
$validUser = true;
$searchResult = '<h1 align="center" style="margin-top: 120px;">Search Result</h1><div class="searchResult">';
if (isset($empid)) {
    $query = '';
    switch ($empIDLastLetter) {
        case "S":
            $query = " SELECT * FROM student WHERE indexNumber = '$empid'";
            break;
        case "T":
            $query = " SELECT * FROM teacher WHERE indexNumber = '$empid'";
            $teacherCheck= true;
            break;
        case "O":
            if(isset($_GET['teacher'])){
                $teacher = true;
            }
            else {
                $query = " SELECT * FROM owner WHERE indexNumber = '$empid'";
            }
            break;
        default:
            $validUser = false;
            $searchResult.='<b style="font-size: medium;">Invalid Index number !</b><br>';
            break;
    }
    if($validUser && !$teacher) {
        $result = runQuery($query);
        $row = mysqli_fetch_object($result);
    }
}

if($validUser && !$teacher && sizeof($row)>0) {
            $searchResult.='<img src="' . $row->profilePic . '"
                 class="resultImage"><p id="searchedData">';
            $searchResult.='Name : '.$row->firstName.' '.$row->lastName.'<br>';
            $searchResult.='Address : '.$row->address.'<br>';
    $searchResult.='Birth Day : '.$row->birthDay.'<br>';
    $searchResult.='Gender : '.$row->gender.'<br>';
    $searchResult.='Email : <a href="https://mail.google.com/mail/u/0/?view=cm&fs=1&to='.$row->email.'&tf=1" target="_blank" title="Send mail(*this work only with gmail clients)">'.$row->email.'</a><br>';
    $searchResult.='Telephone : <a href="tel:'.$row->telephone.'" title="Call him">'.$row->telephone.'</a><br>';

    if ($teacherCheck) {
        $searchResult .= 'Edu Qualifi : '.$row->eduQualification;
    }
    $searchResult .= '</p></div>';
}
else{
    $searchResult.='<b style="font-size: medium;">No result Found!</b>';
}

echo $searchResult;

mysqli_close($connection); // Connection Closed
?>

</body>
</html>
