<?php
require_once '../core/init.php';

    $mLocation = "SMD1-1";
    $mValues = "0";
    $mTypes = "2";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
        if(isset($_POST["mLocation"])) $mLocation = $_POST["mLocation"];
        if(isset($_POST["mValues"])) $mValues = $_POST["mValues"];
        if(isset($_POST["mTypes"])) $mTypes = $_POST["mTypes"];
        
        $myFile = "testFile.json";
        $jsonString = file_get_contents($myFile);
        $data = json_decode($jsonString, true);
        foreach ($data as $key => $entry) {
            if ($entry['Location'] == $mLocation) {
                $data[$key]['Value'] = $mValues;
                $data[$key]['Types'] = $mTypes;
                $data[$key]['LastModify'] = $date_current;
            }
        }
        $newJsonString = json_encode($data);
        file_put_contents($myFile, $newJsonString);
        echo '{ "success": true }';
    }
    else {
    echo "KHÔNG CÓ DỮ LIỆU HTTP POST.";
    }

?>