<?php
// $csv = 'robot-logs-2023-08-25-06-55-35-633-53566.csv';
// $csv = 'readDataCSV/Purchase Order Task Logs.csv';

// echo "<pre>";
// print_r($_FILES['fileUpload']);
$files = $_FILES['fileUpload'];

$info = pathinfo($_FILES['fileUpload']['name']);
// echo "<pre>";
// print_r($info);

// die();

if(strtolower($info['extension']) != "csv") {
    echo "<script>alert('Only csv file needs to be uploaded!'); location.href='/UIPath extractor/';</script>";
    die();
}

// die();

$fp = fopen($files['tmp_name'], "r");


error_reporting(0);

$arrayActivity = [];
$timeZoneArray = [];
$timeStampArray = [];

$CapturedByUserDomainName;

$count = 0;

while (!feof($fp)) {
    $res = fgetcsv($fp)[6];
    $timeZone = fgetcsv($fp)[0];
    $strPosVal = strpos($res, ".xaml");
    
    if(!empty(fgetcsv($fp)[4])) {
        $CapturedByUserDomainName = fgetcsv($fp)[4];
    }

    if (!empty($strPosVal)) {
        $finalRes = explode(".xaml", $res);
        // echo "<pre>";
        // print_r($finalRes);
        if (strpos($finalRes[1], 'Executing')) {
            array_push($arrayActivity, trim($finalRes[0]));

            $date_in = $timeZone;
            $dt = new DateTime($date_in);
            $date1 = $dt->format('Y-m-d\TH:i:s.') . substr($dt->format('u'), 0, 3) . 'Z';
            array_push($timeZoneArray, $date1);
            
            $timeStamp = strtotime($date1);
            array_push($timeStampArray, $timeStamp);

            $count++;
        }
    }
}


if($count == 0) {
    echo "<script>alert('Invalid Format CSV!'); location.href='/UIPath extractor/';</script>";
    die();
}


// print_r(($arrayActivity));

$capturedByUserName = "Qualesce Extractor";
$finalRes = '<?xml version="1.0" encoding="utf-8"?>
    <CaptureOnce xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" version="V2.0" captureType="Standalone" captureVersion="12.0.2201.20" modelVersion="3">
        <CapturedByUserName>'.$capturedByUserName.'</CapturedByUserName>
        <CapturedByUserDomainName>'.$CapturedByUserDomainName.'</CapturedByUserDomainName>
        <CaptureName>'.$info['filename'].'</CaptureName>
        <CaptureDescription>'.$info['filename'].'</CaptureDescription>
        <CaptureGuid>d97ac205-c300-4652-98d8-e184fbd00eec</CaptureGuid>
        <CapturedInterfaces>
            <CapturedInterface>System</CapturedInterface>
            <CapturedInterface>SAP</CapturedInterface>
        </CapturedInterfaces>
        <Maps/>
        <Steps>';

$stepsLoopString = '';
for ($i = 0; $i < count($arrayActivity); $i++) {
    $stepsLoopString .= '<Step InterfaceName="System" ProcessName="" ParentProcessName="" TimeStamp="'.$timeStampArray[$i].'" ISO8601TimeStamp="'.$timeZoneArray[$i].'">
    <Window>
    <PhysicalName>Window</PhysicalName>
    <ImageIndex>-1</ImageIndex>
    </Window>
    <Object>
    <PhysicalName>Execution</PhysicalName>
    <Component>Execution</Component>
    <ImageIndex>-1</ImageIndex>
    <ID/>
    </Object>
    <Action Name="Name Activity" ValidParameterValues="true">
    <Parameter>
    <Name>Activity</Name>
    <Value>'.$arrayActivity[$i].'</Value>
    </Parameter>
    </Action>
    <WindowImage/>
    <ObjectImage/>
    <StepDataCollection>
        <StepData>
            <Name>StepNamedActivity</Name>
            <DataObject>'.$arrayActivity[$i].'</DataObject>
        </StepData>
    </StepDataCollection>
    </Step>';
}
$finalRes = $finalRes . $stepsLoopString . '
    </Steps>
    </CaptureOnce>';

// echo $finalRes;

$fileName =  $info['filename'].".xml";
$fp = fopen($fileName, "w+");
file_put_contents($fileName, $finalRes);

header('Content-type: application/xml');
header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
header('Content-Transfer-Encoding: binary');
readfile($fileName);

unlink($fileName);

?>
