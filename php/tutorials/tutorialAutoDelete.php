<?php
///////////////////// tutorials delete after 3 months////////////////////////////
$qry_dlfile="SELECT filePath FROM tutorials WHERE uploadedDate < NOW() - INTERVAL 90 DAY";
$qry="DELETE FROM tutorials WHERE uploadedDate < NOW() - INTERVAL 90 DAY";
while($path = mysqli_fetch_assoc(runQuery($qry_dlfile))){
    unlink($path['filePath']);
}
runQuery($qry);
///////////////////// tutorials delete after 3 months////////////////////////////
?>