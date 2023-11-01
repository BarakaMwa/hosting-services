<?php
//todo validation
require_once '../../headers-api.php';
session_start();
require_once '../../connection.php';
//require_once '../../connection-local.php';

require_once '../../errors/Responses.php';
require_once '../../class.devices.php';

$response = array();
$status = false;
$devices = new Devices();
$responses = new Responses();
const Entity = "Device";

if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] = 'GET') {

//    todo encrypt
    /* foreach ($result as $row) {
         $encrypted = encrypt($row['vendor_id'],$ciphering,$encryption_iv,$options);
         $row["vendor_id"] = $encrypted;
         $row["0"] = $encrypted;
     }*/

    try {
        $result = $devices->getAllDevices();
        $responses->successDataRetrieved($response, $result, Entity);
    } catch (JsonException $e) {
        $responses -> warningInput("Error retrieving Devices");
    }

} else {

    $responses -> errorInvalidRequest($response);
}


