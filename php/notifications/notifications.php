<?php
require ("phpmail.php");

$qry="DELETE FROM notifications WHERE sendDate < NOW() - INTERVAL 7 DAY";
runQuery($qry);

$remainder = 'This is the reminder to pay your tution fees within first two weeks';
$query_fees_check = "SELECT * FROM notifications WHERE notice='$remainder'";
$remainder_result = runQuery($query_fees_check);
if((strval(date('d')) == '1') && (mysqli_num_rows($remainder_result)<1))  {
    $query_re="INSERT INTO notifications (notice,receiver,sender,sendDate)  VALUE ('{$remainder}','Students','Yureka Institute',CURDATE())";
    runQuery($query_re);
    $query_re_s = "SELECT email FROM student";
    $mails = runQuery($query_re_s);
    while ($mail=mysqli_fetch_assoc($mails)){
        sendMail($mail['email'],"Yureka notification from",$remainder.'<br><br><br><a href=\'#\'>Yureka Higher Education Institute</a> All Rights Reserved!',"Yureka Institute");
    }
}

function loadData($user){
    $sql = "SELECT * FROM notifications WHERE receiver='{$user}' OR receiver='All'";
    $result=runQuery($sql);
    $notices=array();
    $sender=array();
    $sendDates = array();
    $details=array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            array_push($notices, $row['notice']);
            array_push($sender,"From ".$row['sender']);
            array_push($sendDates,$row['sendDate']);
        }
    }
    $notices=array_reverse($notices);
    $sender=array_reverse($sender);
    $sendDates = array_reverse($sendDates);
    $details[1]=$notices;
    $details[0]=$sender;
    $details[2] = $sendDates;
    return $details;
}


$notifiLogo = "../img/nav/notifiIcon_1.png";
function loadNotifiPanel($notifiArray){
    global  $notifiLogo;
    $noOfNotifi = sizeof($notifiArray[0]);
    $notifyPanel = "";
    for($i=0;$i<$noOfNotifi;$i++){
        if(date("Y-m-d")==$notifiArray[2][$i]){
            $notification = "<div class='notification new'>";
            $notifiLogo= "../img/nav/notifiIcon_2.png";
        }else {
            $notification = "<div class='notification'>";
        }
        $notification.= '<h3 class="notifiSender">'.$notifiArray[0][$i].'</h3>';
        $notification.='<p class="notifiContent">'.$notifiArray[1][$i].'</p>';
        $notification.='<lable style="margin-left:85%; color: lightgray;">Received '.$notifiArray[2][$i].'</lable>';
        $notification.='</div>';
        $notifyPanel.=$notification;
    }
    return $notifyPanel;
}

function sendNotification($sender){
    $notice=$_POST['notice'];
    $receiver=$_POST['receiver'];
    $sql="INSERT INTO notifications (notice,receiver,sender,sendDate)  VALUE ('{$notice}','{$receiver}','{$sender}',CURDATE())";
    runQuery($sql);
}


function sendNotificationMail($subject,$sender){
    $receiver=$_POST['receiver'];
    $notice=$_POST['notice'];
    $allMails = array();
    $query_t = "SELECT email FROM teacher";
    $query_s = "SELECT email FROM student";
    if(strtolower($receiver)=='students'){
        unset($allMails);
        $allMails = array();
        $mails = runQuery($query_s);
        while($mail = mysqli_fetch_assoc($mails)){
            array_push($allMails,$mail['email']);
        }
    }else if(strtolower($receiver)=='teachers'){
        unset($allMails);
        $allMails = array();
        $mails = runQuery($query_t);
        while($mail = mysqli_fetch_assoc($mails)){
            array_push($allMails,$mail['email']);
        }
    }else if(strtolower($receiver)=='all'){
        unset($allMails);
        $allMails = array();
        $mails = runQuery($query_t);
        while($mail = mysqli_fetch_assoc($mails)){
            array_push($allMails,$mail['email']);
        }
        $mails = runQuery($query_s);
        while($mail = mysqli_fetch_assoc($mails)){
            array_push($allMails,$mail['email']);
        }
    }

    for($i=0;$i<sizeof($allMails);$i++){
        if($allMails[$i]!=null) {
            sendMail($allMails[$i],$subject, $notice, $sender);
        }
    }

}

?>