<?php
    
    $xml = simplexml_load_file('toRead.xml');

    $finalRes = '<?xml version="1.0" encoding="utf-8"?>
    <CaptureOnce xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" version="' . $xml->attributes()->version . '" captureType="' . $xml->attributes()->captureType . '" captureVersion="' . $xml->attributes()->captureVersion . '" modelVersion="' . $xml->attributes()->modelVersion . '">
        <CapturedByUserName>
            ' . $xml->CapturedByUserName . '
        </CapturedByUserName>
        <CapturedByUserDomainName>
            ' . $xml->CapturedByUserDomainName . '
        </CapturedByUserDomainName>
        <CaptureName>
            ' . $xml->CaptureName . '
        </CaptureName>
        <CaptureDescription>
            ' . $xml->CaptureDescription . '
        </CaptureDescription>
        <CaptureGuid>
            ' . $xml->CaptureGuid . '
        </CaptureGuid>
        <CapturedInterfaces>
            <CapturedInterface>
                ' . $xml->CapturedInterfaces->CapturedInterface[0] . '
            </CapturedInterface>
            <CapturedInterface>
                ' . $xml->CapturedInterfaces->CapturedInterface[1] . '
            </CapturedInterface>
        </CapturedInterfaces>
        <Steps>';

    $list = $xml->Steps->Step;
    // echo count($list);
    $stepsLoopString = '';
    for ($i = 0; $i < count($list); $i++) {
        // echo $list[$i];

        if ($list[$i]->Action->attributes()->Name == "Name Activity") {

            $stepsLoopString .= '
            <Step InterfaceName="' . $list[$i]->attributes()->InterfaceName . '" ProcessName="' . $list[$i]->attributes()->ProcessName . '" ParentProcessName="' . $list[$i]->attributes()->ParentProcessName . '" TimeStamp="' . $list[$i]->attributes()->TimeStamp . '" ISO8601TimeStamp="' . $list[$i]->attributes()->ISO8601TimeStamp . '">
            <Window>
                <PhysicalName>
                    ' . $list[$i]->Window->PhysicalName . '
                </PhysicalName>
                <ImageIndex>
                    ' . $list[$i]->Window->ImageIndex . '
                </ImageIndex>
            </Window>
            <Object>
                <PhysicalName>
                    ' . $list[$i]->Object->PhysicalName . '
                </PhysicalName>
                <Component>
                    ' . $list[$i]->Object->Component . '
                </Component>
                <ImageIndex>
                    ' . $list[$i]->Object->ImageIndex . '
                </ImageIndex>
                <ID />
            </Object>
            <Action Name="' . $list[$i]->Action->attributes()->Name . '" ValidParameterValues="' . $list[$i]->Action->attributes()->ValidParameterValues . '">
                <Parameter>
                    <Name>
                        ' . $list[$i]->Action->Parameter->Name . '
                    </Name>
                    <Value>
                        ' . $list[$i]->Action->Parameter->Value . '
                    </Value>
                </Parameter>
            </Action>
            <WindowImage />
            <ObjectImage />
        </Step>';
        }
    }

    $finalRes = $finalRes . $stepsLoopString . '
    </Steps>
    </CaptureOnce>';
    $fileName = $xml->CaptureGuid . ".xml";
    $fp = fopen($fileName, "w+");
    file_put_contents($fileName, $finalRes);

    header('Content-type: application/xml');
    header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
    header('Content-Transfer-Encoding: binary');
    readfile($fileName);
?>