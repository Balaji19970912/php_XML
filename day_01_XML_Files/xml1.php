<?php
$xml = simplexml_load_file('toRead.xml');
// echo "<pre>";
// print_r($xml);
// echo "</pre>";
// echo '<h2>Employees Listing</h2>';
$list = $xml->Steps->Step;
// echo count($list);
for ($i = 0; $i < count($list); $i++) {
    // echo $list[$i];

    if($list[$i]->Action->attributes()->Name == "Name Activity") {
        echo "<br/>";
        echo 'Parameters Name:'.$list[$i]->Action->Parameter->Name."<br/>";
        echo 'Value:'.$list[$i]->Action->Parameter->Value."<br/>";
    }

   
    // echo '<b>Man no:</b> ' . $list[$i]->attributes()->Name . '<br>';
    // echo 'Name: ' . $list[$i]->Name . '<br>';
    // echo 'Position: ' . $list[$i]->Value . '<br><br>';
}
?>