<?php
//todo validation
require_once '../../headers-api.php';
require_once '../../../Database/LocalDatabase.php';
require_once '../../../Responses/Responses.php';
require_once '../../../Services/DevicesService.php';

session_start();

$response = array();
$status = false;
$devices = new Services\DevicesService();
$responses = new Responses\Responses();
const Entity = "Device";

if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] = 'GET') {

//    todo encrypt
    /* foreach ($result as $row) {
         $encrypted = encrypt($row['vendorId'],$ciphering,$encryption_iv,$options);
         $row["vendorId"] = $encrypted;
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


