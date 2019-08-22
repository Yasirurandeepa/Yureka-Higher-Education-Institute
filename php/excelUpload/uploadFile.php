<?php
require 'Classes/PHPExcel/IOFactory.php';

function deleteResultfromDB($index,$subject){
    $qery_search = "SELECT * FROM results WHERE indexNumber='{$index}' AND subject='{$subject}'";
    if(runQuery($qery_search)) {
        $query_delete = "DELETE FROM results WHERE indexNumber='{$index}' AND subject='{$subject}'";
        runQuery($query_delete);
    }
}

function saveToDB($file_tmp,$subject){
    $inputfilename = $file_tmp;
    global $connection;
//  Read your Excel workbook
    try
    {
        $inputfiletype = PHPExcel_IOFactory::identify($inputfilename);
        $objReader = PHPExcel_IOFactory::createReader($inputfiletype);
        $objPHPExcel = $objReader->load($inputfilename);
    }
    catch(Exception $e)
    {
        die('Error loading file "'.pathinfo($inputfilename,PATHINFO_BASENAME).'": '.$e->getMessage());
    }

//  Get worksheet dimensions
    $sheet = $objPHPExcel->getSheet(0);
    $highestRow = $sheet->getHighestRow();
    $highestColumn = $sheet->getHighestColumn();

//  Loop through each row of the worksheet in turn
    $allDone = true;
    for ($row = 2; $row <= $highestRow; $row++)
    {
        //  Read a row of data into an array
        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
        //  Insert row data array into your database of choice here
        deleteResultfromDB($rowData[0][0],$subject);
        $query_excelSend = "INSERT INTO results (indexNumber, subject, marks) VALUES ('{$rowData[0][0]}','{$subject}','{$rowData[0][1]}')";
        $test = runQuery($query_excelSend);

        if(!$test){
            $allDone = false;
            echo mysqli_error($connection);
        }

    }
    return $allDone;

}

?>
